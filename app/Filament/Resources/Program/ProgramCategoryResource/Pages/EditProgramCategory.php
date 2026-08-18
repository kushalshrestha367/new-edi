<?php

namespace App\Filament\Resources\Program\ProgramCategoryResource\Pages;

use App\Filament\Resources\Program\ProgramCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramCategory extends EditRecord
{
    protected static string $resource = ProgramCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
