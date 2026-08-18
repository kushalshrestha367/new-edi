<?php

namespace App\Filament\Resources\Program;

use App\Filament\Resources\Program\ProgramListResource\Pages;
use App\Filament\Resources\Program\ProgramHasFileResource;
use App\Models\Program\ProgramList;
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
    Hidden,
    Wizard,
    Wizard\Step,
    Repeater,
    FileUpload,
    Select,
    Grid
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

class ProgramListResource extends Resource
{
    protected static ?string $model = ProgramList::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Program Management';
    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Hidden::make('program_category_id')
                ->default(fn($livewire) => $livewire->program_category)
                ->required(),

            Wizard::make([

                /* ---------------- STEP 1 ---------------- */
                Step::make('Program Details')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            TextInput::make('title')
                                ->required(),
                            TextInput::make('short_form'),
                        ]),

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
                Step::make('Program Files')
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
                                        // LEFT SIDE (File Upoad)
                                        FileUpload::make('file_path')
                                            ->required()
                                            ->disk('public')
                                            ->directory('program-files')
                                            ->preserveFilenames(false)
                                            ->reactive()
                                            ->columnSpan(6)
                                            ->imagePreviewHeight('120')
                                            // ->maxSize(2048)
                                            ->enableDownload()
                                            ->enableOpen()
                                            ->afterStateUpdated(function ($state, callable $set) {

                                                if (! $state) {
                                                    return;
                                                }

                                                $file = is_array($state) ? $state[0] : $state;

                                                if ($file instanceof UploadedFile) {
                                                    $extension = Str::lower($file->getClientOriginalExtension());
                                                    $filename  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                                } else {
                                                    $extension = Str::lower(pathinfo($file, PATHINFO_EXTENSION));
                                                    $filename  = pathinfo($file, PATHINFO_FILENAME);
                                                }

                                                $set('file_type', $extension);
                                                $set('file_name', Str::headline($filename));
                                            }),

                                        Grid::make(12)
                                            ->columnSpan(6)
                                            ->schema([
                                                TextInput::make('file_name')
                                                    // ->label('')
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
                        $active   = $record->activeFiles()->count();
                        $inactive = $record->inactiveFiles()->count();

                         return "<span class='text-green-600'>{$active}</span> / <span class='text-red-600'>{$inactive}</span>";
                    })
                    ->html()
                    ->tooltip(fn($state) => "Total files: {$state}"),

                // TextColumn::make('category.title')
                //     ->label('Category')
                //     ->sortable()
                //     ->searchable(),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        Notification::make()
                            ->title('Program Status Changed')
                            ->body("Program '{$record->title}' is now " . ($state ? 'Active' : 'Inactive'))
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
            ->modifyQueryUsing(function ($query, $livewire) {
                if ($livewire->program_category) {
                    $query->where('program_category_id', $livewire->program_category);
                } else {
                    $query->whereRaw('1 = 0');
                }
            })
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->actions([
                // Tables\Actions\Action::make('files')
                //     ->label('Files')
                //     ->icon('heroicon-o-paper-clip')
                //     ->url(fn ($record) =>
                //         ProgramHasFileResource::getUrl('index', [
                //             'program_list' => $record->id,
                //         ])
                //     ),

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
                                ->body('Selected programs status updated.')
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
            'index' => Pages\ListProgramLists::route('/{program_category}/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if ($program_categoryId = request()->get('program_category_id')) {
            $query->where('program_category_id', $program_categoryId);
        }
        return $query;
    }
}
