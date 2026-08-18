<?php

namespace App\Filament\Resources\Program\ProgramListResource\Pages;

use App\Filament\Resources\Program\ProgramListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramList extends EditRecord
{
    protected static string $resource = ProgramListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        if ($program_listId = $this->record->program_list_id ?? request()->get('program_list_id')) {
            $program_listName = ProgramList::find($program_listId)?->title ?? "Service #{$program_listId}";
            $listUrl = $this->getResource()::getUrl('index', ['program_list_id' => $program_listId]);

            $keys = array_keys($breadcrumbs);
            $parentIndex = count($keys) - 2;
            if ($parentIndex >= 0) {
                unset($breadcrumbs[$keys[$parentIndex]]);
                $breadcrumbs = array_slice($breadcrumbs, 0, $parentIndex, true)
                    + [$listUrl => "Program List: {$program_listName} → Items"]
                    + array_slice($breadcrumbs, $parentIndex, null, true);
            }
        }

        return $breadcrumbs;
    }
}
