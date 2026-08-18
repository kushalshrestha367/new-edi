<?php

namespace App\Filament\Resources\Program\ProgramListResource\Pages;

use App\Filament\Resources\Program\ProgramListResource;
use App\Models\Program\ProgramCategory;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Program\ProgramList;

class ListProgramLists extends ListRecords
{
    #[Url()]
    public $program_category;
    protected static string $resource = ProgramListResource::class;

    public function mount(): void
    {
        ProgramCategory::findOrFail($this->program_category);
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

        $program_category = ProgramCategory::find($this->program_category);
        $program_categoryName = $program_category?->title ?? "Program Category #{$this->program_category}";

        $breadcrumbs = [
            // First breadcrumb: back to all program_categories
            route('filament.admin.resources.program.program-categories.index') => 'Program Categories',

            // Second breadcrumb: back to this program_category’s items
            $resource::getUrl('index', ['program_category' => $this->program_category]) => $program_categoryName,

            // Current page breadcrumb (Edit / View / Create etc.)
            ...(filled($breadcrumb = $this->getBreadcrumb()) ? [$breadcrumb] : []),
        ];

        if (filled($cluster = static::getCluster())) {
            return $cluster::unshiftClusterBreadcrumbs($breadcrumbs);
        }

        return $breadcrumbs;
    }
}
