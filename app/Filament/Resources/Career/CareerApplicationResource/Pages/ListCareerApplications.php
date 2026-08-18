<?php

namespace App\Filament\Resources\Career\CareerApplicationResource\Pages;

use App\Filament\Resources\Career\CareerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareerApplications extends ListRecords
{
    protected static string $resource = CareerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
