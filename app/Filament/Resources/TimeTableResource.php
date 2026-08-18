<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeTableResource\Pages;
use App\Models\TimeTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, ImageColumn, ToggleColumn};
use Filament\Forms\Components\{TextInput, TimePicker};
use Carbon\Carbon;
use Filament\Support\Enums\MaxWidth;

class TimeTableResource extends Resource
{
    protected static ?string $model = TimeTable::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Forms\Components\Select::make('day')
            //     ->options([
            //         'Monday' => 'Monday',
            //         'Tuesday' => 'Tuesday',
            //         'Wednesday' => 'Wednesday',
            //         'Thursday' => 'Thursday',
            //         'Friday' => 'Friday',
            //         'Saturday' => 'Saturday',
            //         'Sunday' => 'Sunday',
            //     ])
            //     ->required(),

            TextInput::make('day')
                ->required()
                ->maxLength(255),

            TextInput::make('subject')
                ->maxLength(255),

            TimePicker::make('start_time')
                ->label('Start Time')
                ->withoutSeconds()
                ->required(),

            TimePicker::make('end_time')
                ->label('End Time')
                ->withoutSeconds()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('day')
                    ->sortable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('start_time')
                    ->label('Start Time')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('h:i A'))
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label('End Time')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('h:i A'))
                    ->sortable(),
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
                            ->title("Time Table Status Changed")
                            ->body("The '{$record->name}' has been marked as {$status}.");

                        $status === 'Inactive'
                            ? $notification->danger()
                            : $notification->success();

                        $notification->send();
                    }),

                TextColumn::make('creator.name')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')->label('Updated By')->sortable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')->label('Created At')
                    ->getStateUsing(fn ($record) =>
                        $record->created_at->diffInDays(now()) <= 7
                            ? $record->created_at->diffForHumans()
                            : $record->created_at->format('d M Y, h:i A')
                    )->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->getStateUsing(fn ($record) =>
                        $record->updated_at->diffInDays(now()) <= 7
                            ? $record->updated_at->diffForHumans()
                            : $record->updated_at->format('d M Y, h:i A')
                    )
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->modalWidth(MaxWidth::TwoExtraLarge),
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
                                ->body('Selected time table updated.')
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
            'index' => Pages\ListTimeTables::route('/'),
            // 'create' => Pages\CreateTimeTable::route('/create'),
            // 'edit' => Pages\EditTimeTable::route('/{record}/edit'),
        ];
    }
}
