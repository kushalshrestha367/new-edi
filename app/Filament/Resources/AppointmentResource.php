<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, ToggleColumn};
use Filament\Forms\Components\{Grid, TextInput, Textarea, Toggle, DatePicker, TimePicker, Select};
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Appointments Management';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                TextInput::make('patient_name')
                    ->label('Patient Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->nullable(),
            ]),

            Grid::make(2)->schema([
                TextInput::make('phone')
                    ->label('Phone')
                    ->required()
                    ->maxLength(20),

                DatePicker::make('appointment_date')
                    ->label('Appointment Date')
                    ->required()
                    ->minDate(now()), // prevent back date
            ]),

            Grid::make(2)->schema([
                TimePicker::make('appointment_time')
                    ->label('Time')
                    ->nullable(),

                Select::make('department_has_item_id')
                    ->label('Department')
                    ->relationship('department', 'title')
                    ->searchable(),
            ]),

            Grid::make(2)->schema([
                Select::make('doctor_id')
                    ->label('Doctor')
                    ->relationship('doctor', 'name')
                    ->searchable(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]),

            Textarea::make('notes')
                ->label('Notes')
                ->maxLength(1000),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('id')->sortable(),

                TextColumn::make('appointment_code')->label('code')->searchable()->sortable(),
                TextColumn::make('patient_name')->searchable()->sortable(),
                TextColumn::make('email')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')->sortable(),
                TextColumn::make('appointment_date')->date()->sortable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('appointment_time')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('department.title')->label('Department')->sortable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('doctor.name')->label('Doctor')->sortable()->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_active')
                    ->label('Approval')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Active' : 'Inactive';
                        Notification::make()
                            ->title("Appointment Status Changed")
                            ->body("Appointment for {$record->patient_name} is now {$status}.")
                            ->{$status === 'Inactive' ? 'danger' : 'success'}()
                            ->send();
                    }),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->getStateUsing(fn($record) => $record->creator?->name ?? 'Unknown')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->getStateUsing(fn($record) => $record->updater?->name ?? 'Unknown')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->getStateUsing(fn($record) => Carbon::parse($record->created_at)->diffForHumans())
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable()
                    ->getStateUsing(fn($record) => Carbon::parse($record->updated_at)->diffForHumans())
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('toggleStatus')
                        ->label('Toggle Active')
                        ->icon('heroicon-o-check-circle') // valid icon
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => !$record->is_active]);
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected appointments have been updated.')
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
