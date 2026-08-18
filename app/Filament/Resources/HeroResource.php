<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};
use Filament\Forms\Components\{TextInput, FileUpload, Toggle, Section, RichEditor};
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = 'CMS Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Hero Information')->schema([
                TextInput::make('institution_name')->required()->maxLength(255),
                TextInput::make('institution_short_name')->maxLength(50),
                RichEditor::make('description')->columnSpanFull(),
            ])->columns(2),

            Section::make('Call to Action & Video')->schema([
                TextInput::make('cta_label')->default('Know More'),
                TextInput::make('cta_url')->default('/about'),
                TextInput::make('video_title')->default('Campus Tour'),
                TextInput::make('video_url')->url()->helperText('Full URL to the video'),
                Toggle::make('show_video_button')->default(true),
            ])->columns(2),

            Section::make('Media Assets')->schema([
                FileUpload::make('bg_image_left')->image()->directory('heroes'),
                FileUpload::make('bg_image_right')->image()->directory('heroes'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('institution_name')->searchable()->sortable(),
                TextColumn::make('institution_short_name')->label('Short')->searchable()->sortable(),
                ImageColumn::make('bg_image_left')->label('Left Image')->size(40)->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('bg_image_right')->label('Right Image')->size(40)->toggleable(isToggledHiddenByDefault: true),

                // ToggleColumn::make('is_active')
                //     ->label('Active')
                //     ->sortable()
                //     ->onIcon('heroicon-o-check-circle')
                //     ->offIcon('heroicon-o-x-circle')
                //     ->onColor('success')
                //     ->offColor('danger')
                //     ->afterStateUpdated(function ($state, $record) {
                //         $status = $state ? 'Active' : 'Inactive';
                //         Notification::make()
                //             ->title("Member Status Changed")
                //             ->body("The Hero '{$record->institution_name}' is now {$status}.")
                //             ->{$status === 'Inactive' ? 'danger' : 'success'}()
                //             ->send();
                //     }),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => $record->creator ? $record->creator->name : 'Unknown'),

                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => $record->updater ? $record->updater->name : 'Unknown'),
                TextColumn::make('created_at')->dateTime('d M Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime('d M Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->modalWidth(MaxWidth::TwoExtraLarge),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('toggleStatus')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn(Collection $records) => $records->each->update(['is_active' => !$records->first()->is_active]))
                        ->successNotificationTitle('Status Updated'),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroes::route('/'),
        ];
    }
}
