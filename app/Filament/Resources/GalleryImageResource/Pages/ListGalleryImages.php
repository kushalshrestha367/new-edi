<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use App\Filament\Resources\GalleryResource;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Filament\Actions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Url;

class ListGalleryImages extends ListRecords
{
    #[Url()]
    public $gallery;
    protected static string $resource = GalleryImageResource::class;
    
    public function mount(): void
    {
        Gallery::findOrFail($this->gallery);
        $this->authorizeAccess();

        $this->loadDefaultActiveTab();
    }

    // public function getBreadcrumbs(): array
    // {
    //     $resource = static::getResource();

    //     $breadcrumbs = [
    //         $resource::getUrl('index',['gallery'=>$this->gallery]) => $resource::getBreadcrumb(),
    //         ...(filled($breadcrumb = $this->getBreadcrumb()) ? [$breadcrumb] : []),
    //     ];

    //     if (filled($cluster = static::getCluster())) {
    //         return $cluster::unshiftClusterBreadcrumbs($breadcrumbs);
    //     }

    //     return $breadcrumbs;
    // }

    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        $gallery = Gallery::find($this->gallery);
        $galleryName = $gallery?->title ?? "Gallery #{$this->gallery}";

        $breadcrumbs = [
            GalleryResource::getUrl('index') => 'Gallerys',
            $resource::getUrl('index', ['gallery' => $this->gallery]) => $galleryName,
            ...(filled($breadcrumb = $this->getBreadcrumb()) ? [$breadcrumb] : []),
        ];

        if (filled($cluster = static::getCluster())) {
            return $cluster::unshiftClusterBreadcrumbs($breadcrumbs);
        }

        return $breadcrumbs;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->using(function (array $data, string $model): Model {
                foreach($data['image_path'] as $singleData){
                    $record = new $model;
                    $record->fill([
                        'gallery_id' => $data['gallery_id'],
        'image_path' => $singleData,
                    ]);
                    $record->save();
                }
                
            return $record;
    })
    ->createAnother(false),
        ];
    }
}
