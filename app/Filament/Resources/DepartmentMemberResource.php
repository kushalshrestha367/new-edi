<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentMemberResource\Pages;
use App\Models\DepartmentMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Support\Enums\MaxWidth;
use Carbon\Carbon;
use Filament\Forms\Components\{Grid, TextInput, Toggle, Section, Select};
use Filament\Tables\Columns\{TextColumn, ToggleColumn};
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use App\Models\DepartmentHasItem;

class DepartmentMemberResource extends Resource
{
    protected static ?string $model = DepartmentMember::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Department Management';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([

                Select::make('department_has_item_id')
                    ->label('Departments')
                    // ->multiple()
                    // ->options(DepartmentHasItem::pluck('title', 'id')->toArray())
                    ->relationship('department', 'title')
                    ->required()
                    ->preload()
                    ->searchable(),

                Select::make('member_id')
                    ->relationship('member', 'name')
                    ->label('Member')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),
            ]),

            // Grid::make(3)->schema([
            //     Toggle::make('show_first')
            //         ->label('Show First')
            //         ->default(false),

            //     Toggle::make('is_active')
            //         ->label('Active')
            //         ->default(true),

            //     TextInput::make('sort_order')
            //         ->numeric()
            //         ->nullable()
            //         ->label('Sort Order'),
            // ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('department.title')
                    ->label('Department')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('member.name')
                    ->label('Member')
                    ->sortable()
                    ->searchable(),

                // ToggleColumn::make('show_first')
                //     ->label('Show First')
                //     ->onColor('warning')
                //     ->offColor('secondary')
                //     ->afterStateUpdated(function ($state, $record) {
                //         $status = $state ? 'Shown First' : 'Normal';
                //         Notification::make()
                //             ->title($record->member?->name ?? 'Member')
                //             ->body("Display priority updated: {$status}.")
                //             ->success()
                //             ->send();
                //     }),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Active' : 'Inactive';
                        Notification::make()
                            ->title("Member Status Changed")
                            ->body(($record->member?->name ?? 'Member') . " is now {$status}.")
                            ->{$status === 'Inactive' ? 'danger' : 'success'}()
                            ->send();
                    }),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => Carbon::parse($record->created_at)->diffForHumans()),

                TextColumn::make('updated_at')
                    ->label('Updated')
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
                    BulkAction::make('toggleActive')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => ! $record->is_active]);
                            }
                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected department members updated successfully.')
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
            'index' => Pages\ListDepartmentMembers::route('/'),
            // 'create' => Pages\CreateDepartmentMember::route('/create'),
            // 'edit' => Pages\EditDepartmentMember::route('/{record}/edit'),
        ];
    }
}
