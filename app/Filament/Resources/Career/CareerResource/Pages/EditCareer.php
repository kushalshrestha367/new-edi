<?php

namespace App\Filament\Resources\Career\CareerResource\Pages;

use App\Filament\Resources\Career\CareerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareer extends EditRecord
{
    protected static string $resource = CareerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
