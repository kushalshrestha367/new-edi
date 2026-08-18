<?php

namespace App\Filament\Resources\Program\ProgramCategoryResource\Pages;

use App\Filament\Resources\Program\ProgramCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramCategories extends ListRecords
{
    protected static string $resource = ProgramCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
