<?php

namespace App\Filament\Resources\Downloads\DownloadResource\Pages;

use App\Filament\Resources\Downloads\DownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDownloads extends ListRecords
{
    protected static string $resource = DownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
