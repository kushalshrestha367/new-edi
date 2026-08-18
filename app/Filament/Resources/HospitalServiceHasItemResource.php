<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HospitalServiceHasItemResource\Pages;
use App\Filament\Resources\HospitalServiceHasItemResource\RelationManagers;
use App\Models\HospitalServiceHasItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Forms\Components\{Grid, TextInput, Toggle, Section, Split, Hidden};
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use RalphJSmit\Filament\SEO\SEO;
use Illuminate\Support\Facades\Request;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class HospitalServiceHasItemResource extends Resource
{
    protected static ?string $model = HospitalServiceHasItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('hospital_service_id')
                ->default(fn () => request()->get('hospital_service_id'))
                ->required(),

            Split::make([
                Section::make([
                    TextInput::make('title')
                        ->required()
                        ->columnSpanFull(),

                    TinyEditor::make('description')
                        ->label('Description')
                        ->nullable()
                        ->columnSpanFull()
                        ->minHeight(300)
                        ->maxHeight(700),
                ]), 

                Section::make([
                    ImageLibraryPicker::make('image_path')
                        ->label('Image'),
                ])
                ->grow(false)
                ->extraAttributes(['style' => 'max-width: 300px;']), 
                // ->extraAttributes(['class' => 'filament-image-library-picker-preview']), 
            ])
            ->columnSpanFull()
            ->from('md'), 


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
                            ->getStateUsing(fn ($record) => $record->image_url),

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
                            ->getStateUsing(fn ($record) => $record->creator?->name ?? 'Unknown'),

                        TextColumn::make('updater.name')
                            ->label('Updated By')
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true)
                            ->getStateUsing(fn ($record) => $record->updater?->name ?? 'Unknown'),

                        TextColumn::make('created_at')
                            ->label('Created At')
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true)
                            ->getStateUsing(fn ($record) => Carbon::parse($record->created_at)->diffForHumans()),

                        TextColumn::make('updated_at')
                            ->label('Updated At')
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true)
                            ->getStateUsing(fn ($record) => Carbon::parse($record->updated_at)->diffForHumans()),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHospitalServiceHasItems::route('/'),
            'create' => Pages\CreateHospitalServiceHasItem::route('/create'),
            'edit' => Pages\EditHospitalServiceHasItem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if ($hospitalServiceId = request()->get('hospital_service_id')) {
            $query->where('hospital_service_id', $hospitalServiceId);
        }
        return $query;
    }
}
