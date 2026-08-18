<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Grid, Repeater, Select, TextInput, Textarea, View, Hidden, Section};
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use RalphJSmit\Filament\SEO\SEO;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Carbon\Carbon;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 2;

    public static function canGloballySearch(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                    ->default('Head Office')
                    ->columnSpanFull(),
            Grid::make(3)->schema([
                TextInput::make('email')
                        ->email()
                        ->helperText('If multiple separated by commas ( , )'),
                TextInput::make('phone')
                        ->helperText('If multiple separated by commas ( , )'),
                TextInput::make('fax')
                        ->helperText('If multiple separated by commas ( , )'),
            ]),

            Grid::make(1)->schema([
                Textarea::make('address')->rows(2),
                Textarea::make('map')->rows(2)->visible(false),
            ]),

            Grid::make(2)->schema([
                TextInput::make('latitude')
                    ->numeric()
                    ->nullable(),

                TextInput::make('longitude')
                    ->numeric()
                    ->nullable(),
            ]),

            // View::make('components.contact-map')->columnSpanFull(),

            Repeater::make('socialMedia')
                ->relationship()
                ->reorderable()
                // ->reorderableWithButtons()
                ->orderColumn('sort_order')
                ->live()
                ->label('Social Media Links')
                ->schema([
                    Select::make('icon_name')
                        ->options([
                            'other' => 'Other',
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
                        // ->disableLabel()
                        ->searchable()
                        ->live(),

                    TextInput::make('icon')
                        ->placeholder('e.g. <i class=fab fa-facebook-f></i>')
                        // ->disableLabel()
                        ->disabled(fn ($get) => $get('icon_name') !== 'other')
                        ->suffixAction(
                            Action::make('openFontAwesome')
                                ->icon('heroicon-m-globe-alt')
                                ->tooltip('Click and Paste icon full code')
                                ->url('https://fontawesome.com/v5/search?ic=free')
                                ->openUrlInNewTab()
                                ->disabled(fn ($get) => $get('icon_name') !== 'other')
                        ),

                    TextInput::make('link')
                        ->url()
                        ->required()
                        // ->disableLabel()
                        ->placeholder('https://...'),
                ])
                ->columns(3)
                ->columnSpanFull()
                ->addActionLabel('Add Social Media')
                ->collapsed()
                ->cloneable()
                ->itemLabel(fn (array $state): ?string => $state['icon_name'] ?? null),

            Repeater::make('branches')
                ->label('Branches')
                ->relationship()
                ->reorderable()
                // ->reorderableWithButtons()
                ->orderColumn('sort_order')
                ->schema([
                    TextInput::make('name')->required()->live(),
                    Grid::make(3)->schema([
                        TextInput::make('email')
                                ->email()
                                ->helperText('If multiple separated by commas ( , )'),
                        TextInput::make('phone')
                                ->helperText('If multiple separated by commas ( , )'),
                        TextInput::make('fax')
                                ->helperText('If multiple separated by commas ( , )'),
                    ]),
                        Textarea::make('address')->rows(2)->columnSpanFull(),
                    Grid::make(2)->schema([
                        TextInput::make('latitude')->numeric()->nullable(),
                        TextInput::make('longitude')->numeric()->nullable(),
                    ]),
                    // View::make('components.branch-map')->columnSpanFull(),
                ])
                ->addActionLabel('Add Branch')
                ->columnSpanFull()
                ->collapsed()
                ->cloneable()
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),

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
            ->columns([
                TextColumn::make('name')
                    ->label('Contact Name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('branches')
                    ->label('Branches')
                    ->sortable()
                    ->formatStateUsing(fn ($record) => $record->branches->count())
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('socialMedia')
                    ->label('Social Media')
                    ->sortable()
                    ->formatStateUsing(fn ($record) => $record->socialMedia->count())
                    ->toggleable(isToggledHiddenByDefault: false),

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
            ])
            ->searchable(false);
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
            'index' => Pages\ListContacts::route('/'),
            // 'create' => Pages\CreateContact::route('/create'),
            // 'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

}
