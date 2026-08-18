<?php

namespace App\Filament\Resources\DepartmentHasItemResource\Pages;

use App\Filament\Resources\DepartmentHasItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Department;

class EditDepartmentHasItem extends EditRecord
{
    protected static string $resource = DepartmentHasItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        if ($departmentId = $this->record->department_id ?? request()->get('department_id')) {
            $departmentName = Department::find($departmentId)?->title ?? "Service #{$departmentId}";
            $listUrl = $this->getResource()::getUrl('index', ['department_id' => $departmentId]);

            $keys = array_keys($breadcrumbs);
            $parentIndex = count($keys) - 2;
            if ($parentIndex >= 0) {
                unset($breadcrumbs[$keys[$parentIndex]]);
                $breadcrumbs = array_slice($breadcrumbs, 0, $parentIndex, true)
                    + [$listUrl => "Department: {$departmentName} → Items"]
                    + array_slice($breadcrumbs, $parentIndex, null, true);
            }
        }

        return $breadcrumbs;
    }
}
