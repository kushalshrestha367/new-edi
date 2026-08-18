<?php

namespace App\Filament\Resources\SetupResource\Pages;

use App\Filament\Resources\SetupResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSetup extends EditRecord
{
    protected static string $resource = SetupResource::class;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('edit', ['record' => $this->record->getKey()]);
    }

}
