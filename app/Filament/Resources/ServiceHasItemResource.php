<?php

namespace App\Filament\Resources;

use App\Models\ServiceHasItem;
use App\Filament\Resources\ServiceHasItemResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Forms\Components\{Grid, RichEditor, TextInput, Toggle, Section, Split, Hidden};
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use RalphJSmit\Filament\SEO\SEO;
use Filament\Forms\Components\Actions\Action;

class ServiceHasItemResource extends Resource
{
    protected static ?string $model = ServiceHasItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('service_id')
                ->default(fn() => request()->get('service_id'))
                ->required(),

            Split::make([
                Section::make([
                    TextInput::make('title')
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('icon')
                        ->required()
                        ->columnSpanFull()
                        ->suffixAction(
                            Action::make('browseIcons')
                                ->icon('heroicon-o-arrow-top-right-on-square')
                                ->url('https://fontawesome.com/v6/search?ic=free-collection', shouldOpenInNewTab: true)
                                ->tooltip('Browse Font Awesome icons')
                        ),

                    RichEditor::make('description')
                        ->label('Description')
                        ->nullable()
                        ->columnSpanFull(),
                ])
                    ->columnSpan(2),

                Section::make([
                    ImageLibraryPicker::make('image_path')
                        ->label('Image')
                        ->extraAttributes([
                            'style' => 'max-width:150px; max-height:150px; object-fit:cover;'
                        ]),
                ])
                    ->columnSpan(1)
                    ->grow(true)
                    ->compact(),
            ])
                ->columns(3)
                ->columnSpanFull(),

            Section::make('Meta SEO')
                ->schema([
                    SEO::make(),
                ])
                ->collapsed(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => $record->image_url),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Active' : 'Inactive';
                        Notification::make()
                            ->title('Item Status Changed')
                            ->body("The item '{$record->title}' is now {$status}.")
                            ->{$status === 'Inactive' ? 'danger' : 'success'}()
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
                                ->body('The status of selected items has been updated.')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceHasItems::route('/'),
            'create' => Pages\CreateServiceHasItem::route('/create'),
            'edit' => Pages\EditServiceHasItem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if ($serviceId = request()->get('service_id')) {
            $query->where('service_id', $serviceId);
        }

        return $query;
    }
}
