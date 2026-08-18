<?php

namespace App\Filament\Resources\HospitalServiceHasItemResource\Pages;

use App\Filament\Resources\HospitalServiceHasItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\HospitalService;

class EditHospitalServiceHasItem extends EditRecord
{
    protected static string $resource = HospitalServiceHasItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        if ($hospitalServiceId = $this->record->hospital_service_id ?? request()->get('hospital_service_id')) {
            $hospitalServiceName = HospitalService::find($hospitalServiceId)?->title ?? "Service #{$hospitalServiceId}";
            $listUrl = $this->getResource()::getUrl('index', ['hospital_service_id' => $hospitalServiceId]);

            $keys = array_keys($breadcrumbs);
            $parentIndex = count($keys) - 2;
            if ($parentIndex >= 0) {
                unset($breadcrumbs[$keys[$parentIndex]]);
                $breadcrumbs = array_slice($breadcrumbs, 0, $parentIndex, true)
                    + [$listUrl => "Hospital Service: {$hospitalServiceName} → Items"]
                    + array_slice($breadcrumbs, $parentIndex, null, true);
            }
        }

        return $breadcrumbs;
    }
}
