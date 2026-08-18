<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages;
use App\Models\AboutUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\{Grid, Repeater, TextInput, RichEditor, Section, Wizard, Fieldset}; // Import Fieldset
use Filament\Forms\Components\Wizard\Step;
use Filament\Support\Enums\MaxWidth;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Filament\Tables\Columns\{TextColumn, ImageColumn};
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;
use Carbon\Carbon;
use RalphJSmit\Filament\SEO\SEO;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class AboutUsResource extends Resource 
{

    protected static ?string $model = AboutUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'About Us';
    
    protected static ?string $navigationGroup = 'CMS Management';
    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return static::getModel()::count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Step::make('About Us')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),

                        TinyEditor::make('short_description')
                            ->label('Short Description')
                            ->nullable()
                            ->columnSpanFull()
                            ->minHeight(100)
                            ->maxHeight(300),

                        TinyEditor::make('description')
                            ->label('Description')
                            ->nullable()
                            ->columnSpanFull()
                            ->minHeight(300)
                            ->maxHeight(700),

                        Grid::make(3)->schema([
                            ImageLibraryPicker::make('image_path')
                                ->label('Image')
                                ->required()
                            ])
                    ])->columns(1),

                Step::make('Achievements')
                    ->schema([
                        Repeater::make('achievements')
                            ->relationship('achievements')
                            ->defaultItems(1)
                            ->minItems(0)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Achievement Title')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('icon')
                                    ->label('Icon')
                                    ->suffixAction(
                                        Action::make('openFontAwesome')
                                            ->icon('heroicon-m-globe-alt')
                                            ->tooltip('Click and Paste icon full code')
                                            ->url('https://fontawesome.com/v5/search?ic=free')
                                            ->openUrlInNewTab()
                                    ),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->orderColumn('sort_order'),
                    ]),

                // Use Fieldset within the step to manage the HasOne relationships
                Step::make('Values')
                    ->schema([
                        Fieldset::make('Our Values Details')
                            ->relationship('values') // Link to the 'values' HasOne relationship
                            ->schema([
                                TextInput::make('title')
                                    ->label('Value Title')
                                    ->maxLength(255)
                                    ->nullable(),
                                TextInput::make('icon')
                                    ->label('Value Icon')
                                    ->nullable()
                                    ->suffixAction(
                                        Action::make('openFontAwesome')
                                            ->icon('heroicon-m-globe-alt')
                                            ->tooltip('Click and Paste icon full code')
                                            ->url('https://fontawesome.com/v5/search?ic=free')
                                            ->openUrlInNewTab()
                                    ),
                                RichEditor::make('description')
                                    ->label('Value Description')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ])->columns(1), // Fields for AboutHasValue model
                    ]),

                Step::make('Mission')
                    ->schema([
                        Fieldset::make('Our Mission Details')
                            ->relationship('mission') // Link to the 'mission' HasOne relationship
                            ->schema([
                                TextInput::make('title')
                                    ->label('Mission Title')
                                    ->maxLength(255)
                                    ->nullable(),
                                TextInput::make('icon')
                                    ->label('Mission Icon')
                                    ->nullable()
                                    ->suffixAction(
                                        Action::make('openFontAwesome')
                                            ->icon('heroicon-m-globe-alt')
                                            ->tooltip('Click and Paste icon full code')
                                            ->url('https://fontawesome.com/v5/search?ic=free')
                                            ->openUrlInNewTab()
                                    ),
                                RichEditor::make('description')
                                    ->label('Mission Description')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ])->columns(1), // Fields for AboutHasMission model
                    ]),

                Step::make('Vision')
                    ->schema([
                        Fieldset::make('Our Vision Details')
                            ->relationship('vision') // Link to the 'vision' HasOne relationship
                            ->schema([
                                TextInput::make('title')
                                    ->label('Vision Title')
                                    ->maxLength(255)
                                    ->nullable(),
                                TextInput::make('icon')
                                    ->label('Vision Icon')
                                    ->nullable()
                                    ->suffixAction(
                                        Action::make('openFontAwesome')
                                            ->icon('heroicon-m-globe-alt')
                                            ->tooltip('Click and Paste icon full code')
                                            ->url('https://fontawesome.com/v5/search?ic=free')
                                            ->openUrlInNewTab()
                                    ),
                                RichEditor::make('description')
                                    ->label('Vision Description')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ])->columns(1), // Fields for AboutHasVision model
                    ]),
            ])->columnSpanFull(),

            Section::make('Meta SEO')
                ->schema([
                    SEO::make(),
                ])
                ->collapsed(),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Page Title')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image_url')
                    ->label('Main Image')
                    ->getStateUsing(fn ($record) => $record->image_url),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn ($record) => $record->creator ? $record->creator->name : 'Unknown'),

                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn ($record) => $record->updater ? $record->updater->name : 'Unknown'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(function ($record) {
                        $createdAt = $record->created_at;

                        if (!$createdAt instanceof Carbon) {
                            $createdAt = Carbon::parse($createdAt);
                        }

                        return $createdAt->diffInDays(now()) <= 7
                            ? $createdAt->diffForHumans()
                            : $createdAt->format('d M Y, h:i A');
                    }),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(function ($record) {
                        $createdAt = $record->updated_at;

                        if (!$createdAt instanceof Carbon) {
                            $createdAt = Carbon::parse($createdAt);
                        }

                        return $createdAt->diffInDays(now()) <= 7
                            ? $createdAt->diffForHumans()
                            : $createdAt->format('d M Y, h:i A');
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth(MaxWidth::FourExtraLarge),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutUs::route('/'),
        ];
    }
}