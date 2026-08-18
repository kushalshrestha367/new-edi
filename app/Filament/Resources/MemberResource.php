<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Support\Enums\MaxWidth;
use Carbon\Carbon;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Forms\Components\{Grid, TextInput, Toggle, Section};
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use RalphJSmit\Filament\SEO\SEO;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Department Management';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                TextInput::make('name')
                    ->required()
                    ->autocomplete('off')
                    ->columnSpan(1),
                    
                TextInput::make('designation')
                    ->nullable()
                    ->autocomplete('off')
                    ->columnSpan(1),
            ]),
                
            Grid::make(2)->schema([
                TextInput::make('nmc_number')
                    ->label('Licence Number')
                    ->autocomplete('off')
                    ->nullable(),
                
                TextInput::make('phone')
                    ->autocomplete('off')
                    ->nullable(),
            ]),
                
            Grid::make(2)->schema([
                TextInput::make('email')
                    ->email()
                    ->autocomplete('off')
                    ->nullable(),
                    
                TextInput::make('fax')
                    ->autocomplete('off')
                    ->nullable(),
            ]),

            
            Grid::make(2)->schema([
                TextInput::make('address')
                    ->nullable(),

                ImageLibraryPicker::make('image_path')
                    ->label('Image')
                    ->nullable(),
            ]), 

            Grid::make(1)->schema([
                // Toggle::make('show_first')
                //     ->label('Show First')
                //     ->default(false)
                //     ->columnSpan(1),

                Toggle::make('has_appointment')
                    ->label('Appointment ?')
                    ->default(true)
                    ->columnSpan(1),
            ]),

            // Section::make('Meta SEO')
            //     ->schema([
            //         SEO::make(),
            //     ])
            //     ->collapsed(),
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
                    ->getStateUsing(fn ($record) => $record->image_url)
                    ->square()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('designation')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nmc_number')
                    ->label('NMC No.')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('email')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
                            ->{ $status === 'Hidden' ? 'danger' : 'success' }()
                            ->send();
                    }),

                // ToggleColumn::make('show_first')
                //     ->label('Show First')
                //     ->sortable()
                //     ->onIcon('heroicon-o-check-circle')
                //     ->offIcon('heroicon-o-x-circle')
                //     ->onColor('warning')
                //     ->offColor('danger')
                //     ->afterStateUpdated(function ($state, $record) {
                //         $status = $state ? 'Shown' : 'Hidden';
                //         Notification::make()
                //             ->title("{$record->name}")
                //             ->body("Show First is now {$status}.")
                //             ->{ $status === 'Hidden' ? 'danger' : 'success' }()
                //             ->send();
                //     }),

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
                            ->title("Member Status Changed")
                            ->body("{$record->name} is now {$status}.")
                            ->{ $status === 'Inactive' ? 'danger' : 'success' }()
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
                                ->title('Member Status Updated')
                                ->body('The status of selected members has been updated.')
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
            'index' => Pages\ListMembers::route('/'),
            // 'create' => Pages\CreateMember::route('/create'),
            // 'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
