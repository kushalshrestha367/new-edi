<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentHasItemResource\Pages;
use App\Filament\Resources\DepartmentHasItemResource\RelationManagers;
use App\Models\DepartmentHasItem;
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

class DepartmentHasItemResource extends Resource
{
    protected static ?string $model = DepartmentHasItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('department_id')
                ->default(fn($livewire) => $livewire->department)
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

            Grid::make(1)->schema([
                Toggle::make('has_appointment')
                    ->label('Appointment ?')
                    ->default(true)
                    ->columnSpan(1),
            ]),

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

                ToggleColumn::make('has_appointment')
                    ->label('Appointment ?')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('info')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Shown' : 'Hidden';
                        Notification::make()
                            ->title("{$record->name}")
                            ->body("Show First is now {$status}.")
                            ->{$status === 'Hidden' ? 'danger' : 'success'}()
                            ->send();
                    }),

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
            ->modifyQueryUsing(function ($query, $livewire) {
                if ($livewire->department) {
                    $query->where('department_id', $livewire->department);
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
            'index' => Pages\ListDepartmentHasItems::route('/{department}/'),
            // 'create' => Pages\CreateDepartmentHasItem::route('/create'),
            // 'edit' => Pages\EditDepartmentHasItem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if ($departmentId = request()->get('department_id')) {
            $query->where('department_id', $departmentId);
        }
        return $query;
    }
}
