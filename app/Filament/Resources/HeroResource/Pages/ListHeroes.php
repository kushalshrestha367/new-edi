<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeroes extends ListRecords
{
    protected static string $resource = HeroResource::class;

    protected function getHeaderActions(): array
    {
        if (\App\Models\Hero::exists()) {
            return [];
        }
        return [
            Actions\CreateAction::make(),
        ];
    }
}
