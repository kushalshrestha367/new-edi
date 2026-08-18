<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyChooseUsResource\Pages;
use App\Filament\Resources\WhyChooseUsResource\RelationManagers;
use App\Models\WhyChooseUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, ImageColumn};
use Filament\Forms\Components\{TextInput, Grid, RichEditor};
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class WhyChooseUsResource extends Resource
{
    protected static ?string $model = WhyChooseUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'CMS Management';
    protected static ?int $navigationSort = 3;
    
    

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->required()
                ->columnSpanFull(),

                TinyEditor::make('description')
                    ->nullable()
                    ->minHeight(300)
                    ->maxHeight(700),
                    
            Grid::make(3)->schema([
                ImageLibraryPicker::make('image_path')
                    ->label('Image')
                    ->required()
                    ->columnSpan(1),
            ]),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                ImageColumn::make('image_path')->label('Image')->circular(),
                TextColumn::make('created_at')->dateTime('Y-m-d')->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhyChooseUs::route('/'),
            // 'create' => Pages\CreateWhyChooseUs::route('/create'),
            // 'edit' => Pages\EditWhyChooseUs::route('/{record}/edit'),
        ];
    }
}
