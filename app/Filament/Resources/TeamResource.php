<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Support\Enums\MaxWidth;
use Carbon\Carbon;
use Outerweb\FilamentImageLibrary\Filament\Forms\Components\ImageLibraryPicker;
use Filament\Forms\Components\{Grid, TextInput, Toggle, Repeater, Section, TextArea, Select};
use Filament\Tables\Columns\{TextColumn, ToggleColumn, ImageColumn};
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use RalphJSmit\Filament\SEO\SEO;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'CMS Management';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->columnSpanFull(),

            TextInput::make('designation')
                ->nullable()
                ->columnSpanFull(),
            TextInput::make('academic')
                ->nullable()
                ->columnSpanFull(),

            Grid::make(3)->schema([
                TinyEditor::make('message')
                    ->label('Message')
                    ->nullable()
                    ->columnSpan(2)
                    ->minHeight(300)
                    ->maxHeight(700),

                ImageLibraryPicker::make('image_path')
                    ->label('Image')
                    ->required()
                    ->columnSpan(1),
            ]),

            TinyEditor::make('bio')
                ->label('Bio')
                ->nullable()
                ->columnSpan(2)
                ->minHeight(300)
                ->maxHeight(700),

            Repeater::make('media')
                ->relationship('media')
                ->label('Social Media Links')
                ->schema([
                    Select::make('platform')
                        ->options([
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter (X)',
                            'linkedin' => 'LinkedIn',
                            'instagram' => 'Instagram',
                            'youtube' => 'YouTube',
                            'tiktok' => 'TikTok',
                            'github' => 'GitHub',
                            'snapchat' => 'Snapchat',
                            'pinterest' => 'Pinterest',
                            'reddit' => 'Reddit',
                            'whatsapp' => 'WhatsApp',
                            'telegram' => 'Telegram',
                            'discord' => 'Discord',
                            'threads' => 'Threads',
                            'wechat' => 'WeChat',
                            'skype' => 'Skype',
                            'vimeo' => 'Vimeo',
                            'dribbble' => 'Dribbble',
                            'behance' => 'Behance',
                            'medium' => 'Medium',
                            'tumblr' => 'Tumblr',
                            'slack' => 'Slack',
                            'flickr' => 'Flickr',
                        ])
                        ->required()
                        ->searchable()
                        ->live()
                        ->columnSpan(4),

                    TextInput::make('url')
                        ->url()
                        ->nullable()
                        ->columnSpan(7),

                    // Toggle::make('is_active')
                    //     ->default(true)
                    //     ->columnSpan(2),
                ])
                ->columns(11)
                ->collapsible()
                ->orderable('sort_order')
                ->defaultItems(1)
                ->columnSpanFull()
                ->itemLabel(fn (array $state): ?string => $state['platform'] ?? null),

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

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('designation')
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('has_message')
                    ->label('Message')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('warning')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Shown' : 'Hidden';
                        Notification::make()
                            ->title("{$record->name}")
                            ->body("Message is now {$status}.")
                            ->{ $status === 'Inactive' ? 'danger' : 'success' }()
                            ->send();
                    }),

                ToggleColumn::make('on_menu')
                    ->label('On Menu')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('warning')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        $status = $state ? 'Shown' : 'Hidden';
                        Notification::make()
                            ->title("{$record->name}")
                            ->body("Message is now {$status}.")
                            ->{ $status === 'Inactive' ? 'danger' : 'success' }()
                            ->send();
                    }),

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
                            ->title("Team Member Status Changed")
                            ->body("{$record->name} is now {$status}.")
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
                                $newStatus = $record->is_active ? 0 : 1;
                                $record->update(['is_active' => $newStatus]);
                            }

                            Notification::make()
                                ->title('Team Member Status Updated')
                                ->body('The status of selected team members has been updated.')
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
            'index' => Pages\ListTeams::route('/'),
            // 'create' => Pages\CreateTeam::route('/create'),
            // 'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
