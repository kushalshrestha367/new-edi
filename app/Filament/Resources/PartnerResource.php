<?php

namespace App\Filament\Resources;

use App\Models\Partner;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\{TextInput, RichEditor, Grid};
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Tables\Columns\{TextColumn, ImageColumn, ToggleColumn};
use App\Filament\Resources\PartnerResource\Pages;
use Carbon\Carbon;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'CMS Management';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255),

            TextInput::make('link')
                ->label('Link')
                ->helperText('Please enter the full URL, including https://')
                ->hintColor('primary'),

            RichEditor::make('description')
                ->label('Description')
                ->nullable()
                ->columnSpanFull()
                ->hidden(),
            Grid::make(3)->schema([
                ImageLibraryPicker::make('image_path')
                    ->label('Image')
                    ->required()
            ])
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order') // enables drag-drop sorting
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                // TextColumn::make('description')
                //     ->label('Description')
                //     ->limit(50)
                //     ->toggleable(isToggledHiddenByDefault: true)
                //     ->formatStateUsing(fn ($state) => strip_tags($state)),

                ImageColumn::make('image_url')
                    ->label('Image')
                    ->getStateUsing(fn($record) => $record->image_url),

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
                            ->title("District Status Changed")
                            ->body("The '{$record->title}' has been marked as {$status}.");

                        $status === 'Inactive'
                            ? $notification->danger()
                            : $notification->success();

                        $notification->send();
                    }),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->getStateUsing(
                        fn($record) =>
                        $record->created_at->diffInDays(now()) <= 7
                            ? $record->created_at->diffForHumans()
                            : $record->created_at->format('d M Y, h:i A')
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->getStateUsing(
                        fn($record) =>
                        $record->updated_at->diffInDays(now()) <= 7
                            ? $record->updated_at->diffForHumans()
                            : $record->updated_at->format('d M Y, h:i A')
                    )
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // actions and bulk actions as before...
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->modalWidth(MaxWidth::FourExtraLarge),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('toggleStatus')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => !$record->is_active]);
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected partner statuses updated.')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ])
            ])
        ;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            // 'create' => Pages\CreatePartner::route('/create'),
            // 'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
