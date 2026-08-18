<?php

namespace App\Filament\Resources\GalleryVideoResource\Pages;

use App\Filament\Resources\GalleryVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGalleryVideos extends ListRecords
{
    protected static string $resource = GalleryVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
