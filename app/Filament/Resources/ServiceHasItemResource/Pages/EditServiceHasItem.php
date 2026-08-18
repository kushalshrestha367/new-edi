<?php

namespace App\Filament\Resources\ServiceHasItemResource\Pages;

use App\Filament\Resources\ServiceHasItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Request;

class EditServiceHasItem extends EditRecord
{
    protected static string $resource = ServiceHasItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


}
