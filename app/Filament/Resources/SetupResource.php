<?php

namespace App\Filament\Resources;

use App\Models\Setup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use App\Filament\Resources\SetupResource\Pages;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Forms\Components\{TextInput, ColorPicker, Select, Toggle, Card, Group, Textarea};
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Columns\{TextColumn, IconColumn,ImageColumn};
use RalphJSmit\Filament\SEO\SEO;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Carbon\Carbon;

class SetupResource extends Resource 
{
    protected static ?string $model = Setup::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Site Setups';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 1;

    public static function canGloballySearch(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('site_theme')
                ->label('')
                ->options([
                    'starter' => 'Starter',
                    'modern' => 'Modern',
                    'classic' => 'Classic',
                    'corporate' => 'Corporate',
                    'creative' => 'Creative',
                ])
                ->placeholder('Select a site theme')
                ->required(),

            Toggle::make('maintenance_mode')
                ->label('Maintenance Mode'),

            ColorPicker::make('primary_color')
                ->label('Primary Color')
                ->required(),

            ColorPicker::make('secondary_color')
                ->label('Secondary Color'),
                
            TextInput::make('site_tagline')
                ->label('Slogan'),

            // ColorPicker::make('light_color')
            //     ->label('Light Color')
            //     ->required(),

            // ColorPicker::make('dark_color')
            //     ->label('Dark Color'),

            // Textarea::make('footer_text')
            //     ->label('Footer Text'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('site_theme'),
                TextColumn::make('primary_color')->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('secondary_color')->toggleable(isToggledHiddenByDefault: false),
                IconColumn::make('maintenance_mode')
                    ->boolean(),
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
            ->actions([
                Tables\Actions\EditAction::make()
                                        ->slideOver()
                                        ->modalWidth(MaxWidth::ThreeExtraLarge),
            ])
            ->searchable(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSetups::route('/'),
            // 'edit' => Pages\EditSetup::route('/{record}/edit'),
        ];
    }
}
