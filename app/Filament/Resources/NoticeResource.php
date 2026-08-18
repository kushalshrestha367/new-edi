<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoticeResource\Pages;
use App\Models\Notice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\{TextColumn, ImageColumn, ToggleColumn};
use Filament\Forms\Components\{TextInput, Grid, FileUpload, DatePicker, Select};
use Filament\Notifications\Notification;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Illuminate\Database\Schema\Builder;

class NoticeResource extends Resource
{
    protected static ?string $model = Notice::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Notices';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Grid::make(2)->schema([
                Select::make('type')
                    ->label('Notice Type')
                    ->options([
                        'general' => 'General',
                        'news' => 'News',
                        'event' => 'Event',
                        'important' => 'Important',
                        'exam' => 'Exam',
                        'admission' => 'Admission',
                        'result' => 'Result',
                    ])
                    ->default('general')
                    ->required()
                    ->native(false),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('date_show')
                    ->label('Display Date'),
            ]),

            TinyEditor::make('description')
                ->label('Description')
                ->nullable()
                ->minHeight(300)
                ->maxHeight(700),

            Grid::make(2)->schema([
                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('notices/images')
                    ->nullable()
                    ->maxSize(2048),

                FileUpload::make('file_path')
                    ->label('Attachment File')
                    ->disk('public')
                    ->directory('notices/files')
                    ->nullable()
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
            ]),

            /*Grid::make(3)->schema([
                    Toggle::make('is_scroll')->label('Scroll on Homepage')->default(false),
                    Toggle::make('is_popup')->label('Show as Popup')->default(false),
                ]),*/
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order', 'desc')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->getStateUsing(
                        fn($record) =>
                        $record->image_path ? Storage::disk('public')->url($record->image_path) : null
                    )
                    ->extraAttributes(['class' => 'rounded'])
                    ->size(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('file_path')
                    ->label('File')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->formatStateUsing(function ($state) {
                        return $state ? 'File' : null;
                        // return $state ? basename($state) : null;
                    })
                    ->url(fn($record) => $record->file_path ? Storage::disk('public')->url($record->file_path) : null, true)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('title')->sortable()->searchable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->formatStateUsing(fn($state) => strip_tags($state))
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('date_show')
                    ->label('Date')
                    ->date('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Active' : 'Inactive';
                        Notification::make()
                            ->title("Notice Status Changed")
                            ->body("The notice '{$record->title}' has been marked as {$status}.")
                            ->{$state ? 'success' : 'danger'}()
                            ->send();
                    }),

                // ToggleColumn::make('is_scroll')->label('Scroll')->onColor('info'),
                ToggleColumn::make('is_popup')->label('Popup')->onColor('warning'),

                TextColumn::make('creator.name')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')->label('Updated By')->sortable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')->label('Created At')
                    ->getStateUsing(
                        fn($record) =>
                        $record->created_at->diffInDays(now()) <= 7
                            ? $record->created_at->diffForHumans()
                            : $record->created_at->format('d M Y, h:i A')
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')->label('Updated At')
                    ->getStateUsing(
                        fn($record) =>
                        $record->updated_at->diffInDays(now()) <= 7
                            ? $record->updated_at->diffForHumans()
                            : $record->updated_at->format('d M Y, h:i A')
                    )
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->modalWidth(MaxWidth::FourExtraLarge),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('toggleStatus')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => !$record->is_active]);
                            }
                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected notices updated.')
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
            'index' => Pages\ListNotices::route('/'),
        ];
    }
}
