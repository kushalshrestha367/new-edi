<?php

namespace App\Filament\Resources\DepartmentHasItemResource\Pages;

use App\Filament\Resources\DepartmentHasItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Department;

class ListDepartmentHasItems extends ListRecords
{
    #[Url()]
    public $department;
    protected static string $resource = DepartmentHasItemResource::class;

    public function mount(): void
    {
        Department::findOrFail($this->department);
        $this->authorizeAccess();

        $this->loadDefaultActiveTab();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        $department = \App\Models\Department::find($this->department);
        $departmentName = $department?->title ?? "Department #{$this->department}";

        $breadcrumbs = [
            // First breadcrumb: back to all departments
            route('filament.admin.resources.departments.index') => 'Departments',

            // Second breadcrumb: back to this department’s items
            $resource::getUrl('index', ['department' => $this->department]) => $departmentName,

            // Current page breadcrumb (Edit / View / Create etc.)
            ...(filled($breadcrumb = $this->getBreadcrumb()) ? [$breadcrumb] : []),
        ];

        if (filled($cluster = static::getCluster())) {
            return $cluster::unshiftClusterBreadcrumbs($breadcrumbs);
        }

        return $breadcrumbs;
    }


}
