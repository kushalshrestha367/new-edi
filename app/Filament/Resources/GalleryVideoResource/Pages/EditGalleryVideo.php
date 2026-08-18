<?php

namespace App\Filament\Resources\GalleryVideoResource\Pages;

use App\Filament\Resources\GalleryVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGalleryVideo extends EditRecord
{
    protected static string $resource = GalleryVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
