<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsEventResource\Pages;
use App\Models\NewsEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\{TextColumn, ImageColumn, ToggleColumn, BadgeColumn};
use Filament\Forms\Components\{TextInput, Grid, FileUpload, DatePicker, Toggle, Select};
use Filament\Notifications\Notification;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class NewsEventResource extends Resource
{
    protected static ?string $model = NewsEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'News & Events';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Grid::make(2)->schema([
                Select::make('type')
                    ->label('Type')
                    ->options([
                        'news' => 'News',
                        'event' => 'Event',
                    ])
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]),

            TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->disabled()
                ->hidden(fn($get) => true),

            TinyEditor::make('content')
                ->label('Content')
                ->nullable()
                ->minHeight(300)
                ->maxHeight(700),

            Grid::make(2)->schema([
                // LEFT SIDE: Gallery (Full width in left column)
                FileUpload::make('image_path')
                    ->label('Gallery Images')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory(fn($record) => $record ? "news_events/{$record->id}/gallery" : "news_events/temp")
                    ->maxSize(2048)
                    ->maxFiles(5)
                    ->enableReordering()
                    ->imagePreviewHeight('120')
                    ->columnSpan(1)
                    ->nullable(),

                // RIGHT SIDE: Event Fields
                Grid::make(1)->schema([
                    TextInput::make('event_location')
                        ->label('Event Location')
                        ->nullable()
                        ->hidden(fn($get) => $get('type') !== 'event'),

                    DatePicker::make('event_start_date')
                        ->label('Event Start')
                        ->nullable()
                        ->hidden(fn($get) => $get('type') !== 'event'),

                    DatePicker::make('event_end_date')
                        ->label('Event End')
                        ->nullable()
                        ->hidden(fn($get) => $get('type') !== 'event'),

                ])->columnSpan(1),
            ])

            // TextInput::make('sort_order')
            //     ->label('Sort Order')
            //     ->numeric()
            //     ->default(0),

            // Grid::make(3)->schema([
            //     Toggle::make('is_scroll')->label('Scroll')->default(false),
            //     Toggle::make('is_popup')->label('Popup')->default(false),
            //     Toggle::make('is_published')->label('Published')->default(false),
            // ]),

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
                        !empty($record->image_path)
                            ? Storage::disk('public')->url($record->image_path[0])
                            : null
                    )
                    ->extraAttributes(['class' => 'rounded'])
                    ->size(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->colors([
                        'primary' => 'news',
                        'success' => 'event',
                    ]),

                TextColumn::make('title')->sortable()->searchable(),

                TextColumn::make('content')
                    ->label('Content')
                    ->limit(50)
                    ->formatStateUsing(fn($state) => strip_tags($state))
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('event_start_date')
                    ->label('Start Date')
                    ->date('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('event_end_date')
                    ->label('End Date')
                    ->date('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('event_location')
                    ->label('Location')
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_published')
                    ->label('Published')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Published' : 'Unpublished';
                        Notification::make()
                            ->title("News/Event Status Changed")
                            ->body("The item '{$record->title}' has been {$status}.")
                            ->{$state ? 'success' : 'danger'}()
                            ->send();
                    }),

                // ToggleColumn::make('is_scroll')->label('Scroll')->onColor('info'),
                // ToggleColumn::make('is_popup')->label('Popup')->onColor('warning'),

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
                                $record->update(['is_published' => !$record->is_published]);
                            }
                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected items updated.')
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
            'index' => Pages\ListNewsEvents::route('/'),
        ];
    }
}
