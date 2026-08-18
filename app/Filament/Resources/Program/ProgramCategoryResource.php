<?php

namespace App\Filament\Resources\Program;

use App\Filament\Resources\Program\ProgramCategoryResource\Pages;
use App\Filament\Resources\Program\ProgramCategoryResource\RelationManagers;
use App\Models\Program\ProgramCategory;
use App\Models\Program\ProgramList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Filament\Support\Enums\MaxWidth;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Forms\Components\{Grid, TextInput, Toggle, Section};
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use RalphJSmit\Filament\SEO\SEO;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ProgramCategoryResource extends Resource
{
    protected static ?string $model = ProgramCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    // protected static ?string $navigationGroup = 'Program Management';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return ProgramList::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->required()
                ->columnSpanFull(),

            Grid::make(3)->schema([
                TinyEditor::make('description')
                    ->label('Description')
                    ->nullable()
                    ->columnSpanFull()
                    ->minHeight(300)
                    ->maxHeight(700),

                ImageLibraryPicker::make('image_path')
                    ->label('Image')
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
                    ->getStateUsing(fn ($record) => $record->image_url)
                    ->toggleable(isToggledHiddenByDefault: true),

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
                            ->title("Program Category Status Changed")
                            ->body("The Program Category '{$record->title}' is now {$status}.")
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
                Tables\Actions\Action::make('viewPrograms')
                    ->label('Programs')
                    ->icon('heroicon-o-book-open')
                    ->url(fn ($record) => ProgramListResource::getUrl('index', ['program_category' => $record->id])),

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
                                $record->update(['is_active' => !$record->is_active]);
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected program categories status updated.')
                                ->success()
                                ->send();
                        }),
                ]),

                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProgramCategories::route('/'),
            // 'create' => Pages\CreateProgramCategory::route('/create'),
            // 'edit' => Pages\EditProgramCategory::route('/{record}/edit'),
        ];
    }
}
