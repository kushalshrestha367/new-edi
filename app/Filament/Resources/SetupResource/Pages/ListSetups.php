<?php

namespace App\Filament\Resources\SetupResource\Pages;

use App\Filament\Resources\SetupResource;
use App\Models\Setup;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSetups extends ListRecords
{
    protected static string $resource = SetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                                ->visible(fn () => Setup::count() === 0),
        ];
    }
}
