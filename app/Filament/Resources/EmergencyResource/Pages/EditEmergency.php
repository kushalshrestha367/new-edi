<?php

namespace App\Filament\Resources\EmergencyResource\Pages;

use App\Filament\Resources\EmergencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmergency extends EditRecord
{
    protected static string $resource = EmergencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
