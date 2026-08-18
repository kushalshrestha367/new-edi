<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounterResource\Pages;
use App\Models\Counter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, ToggleColumn};
use Filament\Forms\Components\{TextInput, Textarea, Repeater, Section};
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class CounterResource extends Resource
{
    protected static ?string $model = Counter::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'CMS Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Counter Information')->schema([
                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3),

                Repeater::make('counter')
                    ->label('Counters')
                    ->schema([
                        TextInput::make('label')
                            ->required()
                            ->placeholder('e.g. Students'),
                        TextInput::make('value')
                            ->required()
                            ->numeric()
                            ->placeholder('e.g. 5000'),
                        // TextInput::make('icon')
                        //     ->placeholder('e.g. fas fa-user')
                        //     ->helperText('FontAwesome class name'),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->addActionLabel('Add New Metric'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('counter_count')
                    ->label('Items Count')
                    ->getStateUsing(fn($record) => count($record->counter ?? []))
                    ->badge()
                    ->color('primary')
                    ->sortable(),

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
                            ->title("Counter Status Changed")
                            ->body("The counter set is now {$status}.")
                            ->{$status === 'Inactive' ? 'danger' : 'success'}()
                            ->send();
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
                TextColumn::make('created_at')->dateTime('d M Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime('d M Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth(MaxWidth::TwoExtraLarge),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('toggleStatus')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn(Collection $records) => $records->each->update(['is_active' => !$records->first()->is_active]))
                        ->successNotificationTitle('Status Updated'),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCounters::route('/'),
        ];
    }
}
