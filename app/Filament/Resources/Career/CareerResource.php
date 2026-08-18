<?php

namespace App\Filament\Resources\Career;

use App\Filament\Resources\Career\CareerResource\Pages;
use App\Models\Career\Career;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Filament\Support\Enums\MaxWidth;

use Filament\Forms\Components\{
    TextInput,
    Toggle,
    Section,
    Grid,
    DatePicker,
    Repeater
};

use Filament\Tables;
use Filament\Tables\Columns\{
    TextColumn,
    ToggleColumn
};

use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use RalphJSmit\Filament\SEO\SEO;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Career Management';
    protected static ?int $navigationSort = 1;

    protected static bool $shouldRegisterNavigation = true;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)
                ->schema([
                    TextInput::make('title')
                        ->required(),

                    TextInput::make('department'),
                ])
                ->columnSpanFull(),

            // TinyEditor::make('short_description')
            //     ->label('Short Description')
            //     ->nullable()
            //     ->minHeight(150)
            //     ->maxHeight(300)
            //     ->columnSpanFull(),

            TinyEditor::make('description')
                ->label('Description')
                ->nullable()
                ->minHeight(300)
                ->maxHeight(700)
                ->columnSpanFull(),

            // TinyEditor::make('responsibilities')
            //     ->label('Responsibilities')
            //     ->nullable()
            //     ->minHeight(200)
            //     ->maxHeight(500)
            //     ->columnSpanFull(),

            // TinyEditor::make('requirements')
            //     ->label('Requirements')
            //     ->nullable()
            //     ->minHeight(200)
            //     ->maxHeight(500)
            //     ->columnSpanFull(),

            Grid::make(2)
                ->schema([
                    TextInput::make('location')
                        ->required()
                        ->columnSpan(1),

                    TextInput::make('job_type')
                        ->required()
                        ->placeholder('Full Time / Part Time / Remote')
                        ->columnSpan(1),

                    TextInput::make('vacancies')
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->columnSpan(1),

                    TextInput::make('salary')
                        ->nullable()
                        ->placeholder('e.g. NPR 30,000 - 50,000')
                        ->columnSpan(1),

                    DatePicker::make('deadline')
                        ->required()
                        ->columnSpan(1),

                ])
                ->columnSpanFull(),
            Grid::make(2)
                ->schema([
                    Toggle::make('need_mail')
                        ->label('Need notification on mail ?')
                        ->default(true)
                        ->reactive()
                        ->inline(false) // keeps label above, better alignment
                        ->columnSpan(1),

                    TextInput::make('mail_on')
                        ->label('Receiver Email address (organization)')
                        ->email()
                        ->nullable()
                        ->placeholder('e.g. info@everestcollege.edu.np')
                        ->visible(fn($get) => $get('need_mail'))
                        ->columnSpan(1),
                ]),

            Repeater::make('experience')
                ->label('Experience')
                ->columns(1)
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('title')
                                ->label('Title')
                                ->required(),

                            TextInput::make('duration')
                                ->label('Duration')
                                ->nullable(),
                        ])
                ])
                ->defaultItems(1)
                ->columnSpanFull()
                ->collapsible()
                ->collapsed()
                ->live()
                ->itemLabel(
                    fn(array $state): ?string => ($state['title'] ?? 'Experience') .
                        (!empty($state['duration']) ? ' - ' . $state['duration'] : '')
                ),


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
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('department')
                    ->label('Department')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Location')
                    ->sortable(),

                TextColumn::make('job_type')
                    ->label('Job Type')
                    ->sortable(),

                TextColumn::make('vacancies')
                    ->label('Vacancies')
                    ->sortable(),

                TextColumn::make('salary')
                    ->label('Salary')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // TextColumn::make('experience')
                //     ->label('Experience')
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('experience')
                    ->label('Experience')
                    ->formatStateUsing(function ($state) {

                        if (empty($state)) {
                            return '-';
                        }

                        if (is_string($state)) {
                            $state = trim($state);
                            if (! str_starts_with($state, '[')) {
                                $state = '[' . $state . ']';
                            }

                            $decoded = json_decode($state, true);

                            if (json_last_error() === JSON_ERROR_NONE) {
                                $state = $decoded;
                            }
                        }

                        if (! is_array($state)) {
                            return '-';
                        }

                        return collect($state)
                            ->map(function ($item) {
                                $title = $item['title'] ?? null;
                                $duration = $item['duration'] ?? null;

                                return $duration
                                    ? "{$title} ({$duration})"
                                    : $title;
                            })
                            ->filter()
                            ->implode(', ');
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deadline')
                    ->label('Deadline')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->getStateUsing(fn($record) => Carbon::parse($record->deadline)->format('Y-m-d')),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        Notification::make()
                            ->title('Career Status Changed')
                            ->body("Career '{$record->title}' is now " . ($state ? 'Active' : 'Inactive'))
                            ->{$state ? 'success' : 'danger'}()
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
                    BulkAction::make('toggleStatus')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_active' => ! $record->is_active,
                                ]);
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected careers status updated.')
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
            'index' => Pages\ListCareers::route('/'),
        ];
    }
}
