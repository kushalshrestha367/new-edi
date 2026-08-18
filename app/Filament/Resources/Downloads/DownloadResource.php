<?php

namespace App\Filament\Resources\Downloads;

use App\Filament\Resources\Downloads\DownloadResource\Pages;
use App\Models\Downloads\Download;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Filament\Support\Enums\MaxWidth;

use Filament\Forms\Components\{
    TextInput,
    Toggle,
    Section,
    Wizard,
    Wizard\Step,
    Repeater,
    FileUpload,
    Grid,
    Hidden
};

use Filament\Tables;
use Filament\Tables\Columns\{
    TextColumn,
    ToggleColumn
};

use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use RalphJSmit\Filament\SEO\SEO;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class DownloadResource extends Resource
{
    protected static ?string $model = Download::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-arrow-down';
    // protected static ?string $navigationGroup = 'Download Management';
    protected static ?int $navigationSort = 3;

    protected static bool $shouldRegisterNavigation = true;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Wizard::make([

                /* ---------------- STEP 1 ---------------- */
                Step::make('Download Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->columnSpanFull(),

                        TinyEditor::make('short_description')
                            ->label('Short Description')
                            ->nullable()
                            ->minHeight(150)
                            ->maxHeight(300)
                            ->columnSpanFull(),

                        TinyEditor::make('description')
                            ->label('Description')
                            ->nullable()
                            ->minHeight(300)
                            ->maxHeight(700)
                            ->columnSpanFull(),

                        Section::make('Meta SEO')
                            ->schema([
                                SEO::make(),
                            ])
                            ->collapsed(),
                    ]),

                /* ---------------- STEP 2 ---------------- */
                Step::make('Download Files')
                    ->schema([
                        Repeater::make('files')
                            ->relationship()
                            ->label('')
                            ->reorderable('sort_order')
                            ->orderColumn('sort_order')
                            ->defaultItems(0)
                            ->schema([

                                Grid::make(12)
                                    ->schema([
                                        // LEFT SIDE (File Upload)
                                        FileUpload::make('file_path')
                                            ->required()
                                            ->disk('public')
                                            ->directory('download-files')
                                            ->preserveFilenames(false)
                                            ->maxFiles(1)
                                            ->reactive()
                                            ->columnSpan(6)
                                            ->imagePreviewHeight('120')
                                            ->enableDownload()
                                            ->enableOpen()
                                            ->afterStateUpdated(function ($state, callable $set) {

                                                if (! $state) {
                                                    return;
                                                }

                                                $file = is_array($state) ? $state[0] : $state;

                                                if ($file instanceof UploadedFile) {
                                                    $extension = Str::lower($file->getClientOriginalExtension());

                                                    // real filename from uploaded file
                                                    $realFilename = $file->getClientOriginalName();
                                                    $filename = pathinfo($realFilename, PATHINFO_FILENAME);
                                                } else {
                                                    $extension = Str::lower(pathinfo($file, PATHINFO_EXTENSION));

                                                    // for already stored file
                                                    $realFilename = pathinfo($file, PATHINFO_BASENAME);
                                                    $filename = pathinfo($file, PATHINFO_FILENAME);
                                                }

                                                $set('file_type', $extension);

                                                // Display name - editable
                                                $set('file_name', Str::headline($filename));

                                                // Optional: Save real filename separately (if needed)
                                                $set('real_file_name', $realFilename);
                                            }),

                                        Grid::make(12)
                                            ->columnSpan(6)
                                            ->schema([
                                                TextInput::make('file_name')
                                                    ->required()
                                                    ->placeholder('File Name *')
                                                    ->columnSpan(12),

                                                Hidden::make('file_type')
                                                    ->default('')
                                                    ->columnSpan(12)
                                                    ->dehydrated(true),

                                                Toggle::make('is_active')
                                                    ->label('Active')
                                                    ->default(true)
                                                    ->columnSpan(12),
                                            ]),
                                    ]),

                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn(array $state): ?string => $state['file_name'] ?? 'File'),
                    ]),

            ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('files_count')
                    ->label('Files')
                    ->counts('files')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->formatStateUsing(function ($state, $record) {
                        $active   = $record->files()->where('is_active', 1)->count();
                        $inactive = $record->files()->where('is_active', 0)->count();

                        return "<span class='text-green-600'>{$active}</span> / <span class='text-red-600'>{$inactive}</span>";
                    })
                    ->html()
                    ->tooltip(fn($state) => "Total files: {$state}"),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        Notification::make()
                            ->title('Download Status Changed')
                            ->body("Download '{$record->title}' is now " . ($state ? 'Active' : 'Inactive'))
                            ->{$state ? 'success' : 'danger'}()
                            ->send();
                    }),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => $record->creator?->name ?? 'Unknown'),

                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => $record->updater?->name ?? 'Unknown'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => Carbon::parse($record->created_at)->diffForHumans()),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => Carbon::parse($record->updated_at)->diffForHumans()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth(MaxWidth::FourExtraLarge),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('toggleStatus')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_active' => ! $record->is_active,
                                ]);
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected downloads status updated.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDownloads::route('/'),
        ];
    }
}
