<?php

namespace App\Filament\Resources\HospitalServiceResource\Pages;

use App\Filament\Resources\HospitalServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHospitalService extends EditRecord
{
    protected static string $resource = HospitalServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
