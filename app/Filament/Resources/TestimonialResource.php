<?php

namespace App\Filament\Resources;

use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Collection;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Tables\Columns\{TextColumn, ImageColumn, ToggleColumn};
use Filament\Forms\Components\{TextInput, RichEditor, Grid, View, FileUpload};
use Filament\Notifications\Notification;
use App\Filament\Resources\TestimonialResource\Pages;
use Outerweb\ImageLibrary\Models\Image; 
use Illuminate\Support\Facades\Storage;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Testimonials';
    protected static ?string $navigationGroup = 'CMS Management';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1)
                ->schema([
                    FileUpload::make('image_path')
                        ->label('')
                        ->image()
                        ->disk('public')
                        ->directory(fn () => 
                                'testimonials' 
                        )
                        ->nullable()
                        ->avatar()
                        ->imageEditor()
                        ->maxSize(1024)
                        // ->circleCropper()
                        ->required()
                        ->extraAttributes(['class' => 'mx-auto']),
                    ]),
            // Grid::make(3)->schema([
            //     ImageLibraryPicker::make('image_path')
            //         ->label('Image')
            //         ->required()
            //     ]),
            Grid::make(2)->schema([
                TextInput::make('name')->required(),
                TextInput::make('designation')->nullable(),
            ]),

            TinyEditor::make('description')->label('Testimonial')->nullable(),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                // ImageColumn::make('image_url')->label('Image')->getStateUsing(fn ($record) => $record->image_url),

                ImageColumn::make('image_path')
                    ->label('Image')
                    ->getStateUsing(function ($record) {
                        return $record->image_path ? Storage::disk('public')->url($record->image_path) : null;
                    })
                    ->extraAttributes(['class' => 'rounded-full'])
                    ->size(40),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('designation')->sortable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn ($state) => strip_tags($state)),

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
                            ->title("Testimonial Status Changed")
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
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->modalWidth(MaxWidth::FourExtraLarge),
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
                                ->body('Selected testimonials updated.')
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
            'index' => Pages\ListTestimonials::route('/'),
            // 'create' => Pages\CreateTestimonial::route('/create'),
            // 'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
