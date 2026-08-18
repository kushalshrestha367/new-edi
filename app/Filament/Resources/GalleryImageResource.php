<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages;
use App\Models\GalleryImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{TextInput, FileUpload, Hidden};
use Filament\Tables\Columns\{TextColumn, ImageColumn, IconColumn};
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Split;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('gallery_id')
                    ->default(fn ($livewire) => $livewire->gallery)
                    ->required(),
                // FileUpload::make('image_path')
                //     ->label('Image')
                //     ->image()
                //     ->directory('galleries')
                //     ->multiple()
                //     ->required(),

                FileUpload::make('image_path')
                    ->label('Images')
                    ->image()
                    ->directory('galleries')
                    ->multiple()
                    ->reorderable(),

                // TextInput::make('caption')
                //     ->label('Caption')
                //     ->maxLength(255),
                
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Stack::make([
                    Split::make([
                        ImageColumn::make('image_path')
                            ->label('Image')
                            ->width(80)
                            ->height(80)
                            ->url(fn ($record) => Storage::url($record->image_path))
                            ->openUrlInNewTab(),

                        // TextColumn::make('caption')
                        //     ->label('Caption')
                        //     ->sortable()
                        //     ->searchable()
                        //     ->limit(50)
                        //     ->toggleable(isToggledHiddenByDefault: true),

                        TextColumn::make('created_at')
                            ->label('Created')
                            ->dateTime('d M, Y')
                            ->sortable(),

                        IconColumn::make('is_active')
                            ->label('Active')
                            ->boolean()
                            ->translateLabel()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger')
                            ->action(function ($record, $column) {
                                $record->is_active = ! $record->is_active;
                                $record->save();

                                $status = $record->is_active ? 'Active' : 'Inactive';

                                $notification = Notification::make()
                                    ->title("Image Status Changed")
                                    ->body("The '{$record->caption}' has been marked as {$status}.");

                                $record->is_active
                                    ? $notification->success()
                                    : $notification->danger();

                                $notification->send();
                        }),
                    ]),
                ]),
            ])
            ->modifyQueryUsing(function ($query,$livewire) {
                    if ($livewire->gallery) {
                        $query->where('gallery_id', $livewire->gallery);
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                })
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]) 
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Example relation if gallery images belong to a Gallery folder
            // RelationManagers\GalleryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryImages::route('/{gallery}/images'),
            // 'create' => Pages\CreateGalleryImage::route('/create'),
            // 'edit' => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }
}
