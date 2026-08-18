<?php

namespace App\Filament\Resources\DepartmentMemberResource\Pages;

use App\Filament\Resources\DepartmentMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartmentMember extends EditRecord
{
    protected static string $resource = DepartmentMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $departmentIds = $data['department_ids'] ?? [];
    //     $memberId = $data['member_id'];

    //     \App\Models\DepartmentMember::where('member_id', $memberId)->delete();

    //     foreach ($departmentIds as $departmentId) {
    //         \App\Models\DepartmentMember::create([
    //             'member_id' => $memberId,
    //             'department_has_item_id' => $departmentId,
    //         ]);
    //     }

    //     return [];
    // }
}
