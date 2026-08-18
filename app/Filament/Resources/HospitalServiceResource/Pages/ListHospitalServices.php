<?php

namespace App\Filament\Resources\HospitalServiceResource\Pages;

use App\Filament\Resources\HospitalServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHospitalServices extends ListRecords
{
    protected static string $resource = HospitalServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
