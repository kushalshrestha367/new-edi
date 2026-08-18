<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Components\{TextInput, Toggle, RichEditor, Repeater, FileUpload};
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Media Management';
    protected static ?string $navigationLabel = 'Images';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $countItems = GalleryImage::count();

        return $countItems;
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->maxLength(255),
                RichEditor::make('description')->nullable(),

                // Repeater::make('images')
                //     ->relationship('images')
                //     ->schema([
                //         FileUpload::make('image_path')
                //             ->label('Image')
                //             ->image()
                //             ->directory('galleries')
                //             ->required(),

                //         TextInput::make('caption')->maxLength(255)->label('Caption'),
                //     ])
                //     ->columns(2)
                //     ->label('Gallery Images')
                //     ->orderable('id')
                //     ->minItems(1),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                ToggleColumn::make('is_active')->label('Active'),
                TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('addItem')
                    ->label('Item')
                    ->icon('heroicon-o-plus-circle')
                    ->color('sucess')
                    // ->openUrlInNewTab() 
                    ->url(fn ($record) => GalleryImageResource::getUrl('index',['gallery' => $record->id])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
