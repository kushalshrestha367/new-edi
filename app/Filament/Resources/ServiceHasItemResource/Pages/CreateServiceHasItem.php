<?php

namespace App\Filament\Resources\ServiceHasItemResource\Pages;

use App\Filament\Resources\ServiceHasItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Request;

class CreateServiceHasItem extends CreateRecord
{
    protected static string $resource = ServiceHasItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['service_id'] = $data['service_id'] ?? request()->get('service_id');
        return $data;
    }
}
