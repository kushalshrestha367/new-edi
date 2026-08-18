<?php

namespace App\Filament\Resources\HospitalServiceHasItemResource\Pages;

use App\Filament\Resources\HospitalServiceHasItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Request;
use App\Models\HospitalService;

class CreateHospitalServiceHasItem extends CreateRecord
{
    protected static string $resource = HospitalServiceHasItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['hospital_service_id'] = $data['hospital_service_id'] ?? request()->get('hospital_service_id');
        return $data;
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        if ($hospitalServiceId = request()->get('hospital_service_id')) {
            $hospitalServiceName = HospitalService::find($hospitalServiceId)?->title ?? "Service #{$hospitalServiceId}";
            $listUrl = $this->getResource()::getUrl('index', ['hospital_service_id' => $hospitalServiceId]);

            // Replace the second-to-last breadcrumb with custom URL and label
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
