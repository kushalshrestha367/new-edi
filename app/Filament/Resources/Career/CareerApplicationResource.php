<?php

namespace App\Filament\Resources\Career;

use App\Filament\Resources\Career\CareerApplicationResource\Pages;
use App\Models\Career\CareerApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{
    TextColumn,
    ToggleColumn,
};
use Filament\Tables\Actions\{
    ViewAction,
    DeleteAction,
    EditAction,
    Action,
};
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\{
    TextInput,
    Select,
    FileUpload,
    RichEditor
};
use Filament\Notifications\Notification;
use Carbon\Carbon;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\BulkAction;
use Closure;

class CareerApplicationResource extends Resource
{
    protected static ?string $model = CareerApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $navigationLabel = 'Career Applications';
    protected static ?string $navigationGroup = 'Career Management';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('career_id')
                    ->label('Career')
                    ->relationship(
                        name: 'career',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn($query) => $query->orderBy('id', 'desc')->limit(3)
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required(),

                TextInput::make('phone')
                    ->required()
                    ->maxLength(20),

                RichEditor::make('cover_letter')
                    ->label('Cover Letter')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'link',
                        'undo',
                        'redo',
                    ]),


                FileUpload::make('resume_path')
                    ->label('Resume')
                    ->disk('public')
                    // ->directory('resumes')
                    ->directory(fn ($get) => "resumes/{$get('record.id')}")
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(1024) // 1 MB (size is in KB)
                    ->downloadable()
                    ->openable()
                    ->required()
                    ->validationMessages([
                        'required' => 'Please upload your resume.',
                        'mimes'    => 'Only PDF files are allowed.',
                        'max'      => 'The resume file must not exceed 1 MB.',
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('career.title')
                    ->label('Career')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('phone')
                    ->toggleable(isToggledHiddenByDefault: false),

                ToggleColumn::make('is_active')
                    ->label('Status')
                    ->sortable()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($state, $record) {
                        Notification::make()
                            ->title('Applicant Status Changed')
                            ->body("Applicant '{$record->name}' is now " . ($state ? 'Approved' : 'On Hold'))
                            ->{$state ? 'success' : 'danger'}()
                            ->send();
                    }),

                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => $record->updater?->name ?? 'Unknown'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => Carbon::parse($record->created_at)->diffForHumans()),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record) => Carbon::parse($record->updated_at)->diffForHumans()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('career_id')
                    ->label('Career')
                    ->relationship('career', 'title')
                    ->preload()
                    ->searchable()
                    ->options(function () {
                        return \App\Models\Career\Career::orderBy('title', 'ASC')
                            ->limit(3)
                            ->pluck('title', 'id');
                    }),
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Approved',
                        0 => 'On Hold',
                    ]),
            ])
            ->actions([
                ViewAction::make(),

                Action::make('download_resume')
                    ->label('Resume')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => Storage::disk('public')->url($record->resume_path))
                    ->openUrlInNewTab()
                    ->visible(fn($record) => ! empty($record->resume_path)),

                EditAction::make()
                    ->slideOver()
                    ->modalWidth(MaxWidth::FourExtraLarge),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('toggleStatus')
                        ->label('Toggle Status')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_active' => ! $record->is_active,
                                ]);
                            }

                            Notification::make()
                                ->title('Status Updated')
                                ->body('Selected applicants status updated.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])

            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCareerApplications::route('/'),
            // 'create' => Pages\CreateCareerApplication::route('/create'),
            'view'   => Pages\ViewCareerApplication::route('/{record}'),
            // 'edit'   => Pages\EditCareerApplication::route('/{record}/edit'),
        ];
    }
}
