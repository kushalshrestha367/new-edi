<?php

namespace App\Filament\Resources\Program\ProgramListResource\Pages;

use App\Filament\Resources\Program\ProgramListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Program\ProgramList;

class CreateProgramList extends CreateRecord
{
    protected static string $resource = ProgramListResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['program_category_id'] = $data['program_category_id'] ?? request()->get('program_category_id');
        return $data;
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        if ($program_categoryId = request()->get('program_category_id')) {
            $program_categoryName = ProgramList::find($program_categoryId)?->title ?? "Service #{$program_categoryId}";
            $listUrl = $this->getResource()::getUrl('index', ['program_category_id' => $program_categoryId]);

            // Replace the second-to-last breadcrumb with custom URL and label
            $keys = array_keys($breadcrumbs);
            $parentIndex = count($keys) - 2;
            if ($parentIndex >= 0) {
                unset($breadcrumbs[$keys[$parentIndex]]);
                $breadcrumbs = array_slice($breadcrumbs, 0, $parentIndex, true)
                    + [$listUrl => "Program List: {$program_categoryName} → Items"]
                    + array_slice($breadcrumbs, $parentIndex, null, true);
            }
        }

        return $breadcrumbs;
    }
}
