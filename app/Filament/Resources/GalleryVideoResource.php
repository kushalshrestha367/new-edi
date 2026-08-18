<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryVideoResource\Pages;
use App\Models\GalleryVideo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

use Filament\Forms\Components\{Grid, TextInput, Group};
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Columns\{ToggleColumn, TextColumn, ImageColumn};
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Forms\Components\Actions\Action;

class GalleryVideoResource extends Resource
{
    protected static ?string $model = GalleryVideo::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationLabel = 'Videos';

    protected static ?string $navigationGroup = 'Media Management';

    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canGloballySearch(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                Forms\Components\Group::make([
                    TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('embed')
                        ->label('Embed Code')
                        ->placeholder('https://www.youtube.com/watch?v=R3GfuzLMPkA')
                        ->required()
                        ->suffixAction(
                            Action::make('openEmbed')
                                ->icon('heroicon-m-globe-alt')
                                ->tooltip('Open embed link')
                                ->url(fn($get) => $get('embed'))
                                ->openUrlInNewTab()
                                ->disabled(fn($get) => empty($get('embed')))
                        ),
                ])->columnSpan(1),

                Group::make([
                    ImageLibraryPicker::make('image_path')
                        ->label('Thumbnail Image'),
                ])->columnSpan(1),
            ])

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order', 'desc')
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->getStateUsing(fn($record) => $record->image_url)
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('embed')
                    ->label('Embed')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->translateLabel()
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Active' : 'Inactive';

                        $notification = Notification::make()
                            ->title("Video Status Changed")
                            ->body("The '{$record->title}' has been marked as {$status}.");

                        $status === 'Inactive'
                            ? $notification->danger()
                            : $notification->success();

                        $notification->send();
                    }),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => $record->creator ? $record->creator->name : 'Unknown'),

                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => $record->updater ? $record->updater->name : 'Unknown'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(function ($record) {
                        $createdAt = $record->created_at;

                        if (!$createdAt instanceof Carbon) {
                            $createdAt = Carbon::parse($createdAt);
                        }

                        return $createdAt->diffInDays(now()) <= 7
                            ? $createdAt->diffForHumans()
                            : $createdAt->format('d M Y, h:i A');
                    }),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(function ($record) {
                        $createdAt = $record->updated_at;

                        if (!$createdAt instanceof Carbon) {
                            $createdAt = Carbon::parse($createdAt);
                        }

                        return $createdAt->diffInDays(now()) <= 7
                            ? $createdAt->diffForHumans()
                            : $createdAt->format('d M Y, h:i A');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth(MaxWidth::FourExtraLarge),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('changeStatus')
                        ->translateLabel()
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $newStatus = $record->is_active ? 0 : 1;
                                $record->update(['is_active' => $newStatus]);
                            }

                            Notification::make()
                                ->title('Data Status Updated')
                                ->body('The status of selected datas has been updated.')
                                ->success()
                                ->send();
                        }),
                ]),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryVideos::route('/'),
        ];
    }
}
