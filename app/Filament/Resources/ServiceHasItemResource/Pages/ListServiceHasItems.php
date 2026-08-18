<?php

namespace App\Filament\Resources\ServiceHasItemResource\Pages;

use App\Filament\Resources\ServiceHasItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceHasItems extends ListRecords
{
    protected static string $resource = ServiceHasItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(fn () => ServiceHasItemResource::getUrl('create', ['service_id' => request()->get('service_id')]))
                ->visible(fn () => filled(request()->get('service_id'))),
        ];
    }
}
