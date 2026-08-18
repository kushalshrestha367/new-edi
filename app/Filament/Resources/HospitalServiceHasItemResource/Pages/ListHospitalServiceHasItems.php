<?php

namespace App\Filament\Resources\HospitalServiceHasItemResource\Pages;

use App\Filament\Resources\HospitalServiceHasItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\HospitalService;

class ListHospitalServiceHasItems extends ListRecords
{
    protected static string $resource = HospitalServiceHasItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(fn () => HospitalServiceHasItemResource::getUrl('create', ['hospital_service_id' => request()->get('hospital_service_id')]))
                ->visible(fn () => filled(request()->get('hospital_service_id'))),
        ];
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
