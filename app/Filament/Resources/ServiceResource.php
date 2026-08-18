<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use App\Models\ServiceHasItem;
use App\Models\ServiceHasExtra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Support\Enums\MaxWidth;
use Carbon\Carbon;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Forms\Components\{Grid, RichEditor, TextInput, Toggle, Repeater, Section};
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use RalphJSmit\Filament\SEO\SEO;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'CMS Management';
    protected static ?string $navigationLabel = 'Facilities';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $countItems = ServiceHasItem::count();
        $countExtras = ServiceHasExtra::count();

        return $countItems + $countExtras;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->required()
                ->columnSpanFull(),


            Grid::make(3)->schema([
                RichEditor::make('description')
                    ->label('Description')
                    ->nullable()
                    ->columnSpan(2),
                ImageLibraryPicker::make('image_path')
                    ->label('Image')
                    ->columnSpan(1),
                ]),
            Repeater::make('extras')
                ->relationship()
                ->label('Service Extras')
                ->schema([
                    TextInput::make('title')
                        ->disableLabel()
                        ->required()
                        ->columnSpan(4)
                        ->live(),

                    Toggle::make('is_active')
                        ->default(true)
                        ->label('Active')
                        ->columnSpan(1),
                ])
                ->columns(5)
                ->collapsible()
                ->orderable('sort_order')
                ->defaultItems(1)
                ->columnSpanFull()
                ->itemLabel(fn (array $state): ?string => $state['icon_name'] ?? null),

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
                    ->getStateUsing(fn ($record) => $record->image_url),

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
                            ->title("Service Status Changed")
                            ->body("The service '{$record->title}' is now {$status}.")
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
                Tables\Actions\Action::make('addItem')
                    ->label('Item')
                    ->icon('heroicon-o-plus-circle')
                    ->color('sucess')
                    // ->openUrlInNewTab()
                    ->url(fn ($record) => route('filament.admin.resources.service-has-items.index', ['service_id' => $record->id])),
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth(MaxWidth::FourExtraLarge),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('changeStatus')
                        // ->label('Change Status')
                        ->translateLabel()
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $newStatus = $record->is_active ? 0 : 1;
                                $record->update(['is_active' => $newStatus]);
                            }

                            Notification::make()
                                ->title('Data Status Updated')
                                ->body('The status of selected datas has been updated.')
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
            'index' => Pages\ListServices::route('/'),
            // 'create' => Pages\CreateService::route('/create'),
            // 'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
