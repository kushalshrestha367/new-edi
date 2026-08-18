<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\{Grid, Repeater, Select, TextInput, Textarea, View, Hidden, Section};
use Filament\Support\Enums\MaxWidth;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Filament\Tables\Columns\{ToggleColumn, TextColumn, ImageColumn};
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class SliderResource extends Resource 
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    // protected static ?string $navigationGroup = 'Configuration';

    protected static ?int $navigationSort = 4;

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
            TextInput::make('title')
                ->label('Title')
                // ->required()
                ->maxLength(255),

            TextInput::make('subtitle')
                ->label('Subtitle')
                ->maxLength(255)
                ->nullable(),

            // TextInput::make('url')
            //     ->label('Link URL')
            //     ->url()
            //     ->nullable(),

            Grid::make(2)->schema([
                TextInput::make('btn1_name')
                    ->label('Button 1 Name')
                    ->maxLength(255)
                    ->nullable(),

                TextInput::make('btn1_link')
                    ->label('Button 1 Link')
                    ->url()
                    ->nullable(),
            ]),

            Grid::make(2)->schema([
                TextInput::make('btn2_name')
                    ->label('Button 2 Name')
                    ->maxLength(255)
                    ->nullable(),

                TextInput::make('btn2_link')
                    ->label('Button 2 Link')
                    ->url()
                    ->nullable(),
            ]),

            ImageLibraryPicker::make('image_path')
                ->label('Image')
                ->required(),

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
                TextColumn::make('subtitle')
                        ->limit(50)
                        ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => $record->image_url)
                    ->toggleable(isToggledHiddenByDefault: false),
                // Tables\Columns\TextColumn::make('url')->limit(50),
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
                            ->title("Slider Status Changed")
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
                    ->getStateUsing(fn ($record) => $record->creator ? $record->creator->name : 'Unknown'),

                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn ($record) => $record->updater ? $record->updater->name : 'Unknown'),

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
                        // ->label('Change Status')
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
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            // 'create' => Pages\CreateSlider::route('/create'),
            // 'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
