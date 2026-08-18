<?php

namespace App\Filament\Resources\DepartmentMemberResource\Pages;

use App\Filament\Resources\DepartmentMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartmentMember extends CreateRecord
{
    protected static string $resource = DepartmentMemberResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $departmentIds = $data['department_ids'] ?? [];

    //     $departmentIds = array_filter($departmentIds, fn($id) => !empty($id) && is_numeric($id));

    //     unset($data['department_ids']);

    //     foreach ($departmentIds as $departmentId) {
    //         \App\Models\DepartmentMember::create(array_merge($data, [
    //             'department_has_item_id' => $departmentId,
    //         ]));
    //     }

    //     return [];
    // }
}
