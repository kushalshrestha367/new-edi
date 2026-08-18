<?php

namespace App\Filament\Resources\Career\CareerApplicationResource\Pages;

use App\Filament\Resources\Career\CareerApplicationResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCareerApplication extends ViewRecord
{
    protected static string $resource = CareerApplicationResource::class;

    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }

    public function getView(): string
    {
        return 'filament.career-applications.view';
    }
}
