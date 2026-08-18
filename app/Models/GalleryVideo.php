<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Str;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;

class GalleryVideo extends Model  implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'title',
        'embed',
        'image_path',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['image_url'];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected static function booted()
    {
        static::creating(function ($galleryvideo) {
            $galleryvideo->created_by = Auth::id();
            $galleryvideo->slug = Str::slug($galleryvideo->title) . '-' . rand(1000, 9999);
        });

        static::updating(function ($galleryvideo) {
            $galleryvideo->updated_by = Auth::id();

            if ($galleryvideo->isDirty('title')) {
                $galleryvideo->slug = Str::slug($galleryvideo->title) . '-' . rand(1000, 9999);
            }
        });
    }

    public function getImageUrlAttribute()
    {
        return optional(LibraryImage::find($this->image_path))->getUrl('filament-thumbnail');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function getGalleryVideoList(){
        $data_lists = GalleryVideo::orderBy('sort_order', 'DESC')
                           ->orderBy('id', 'DESC')
                           ->where('is_active', True)
                           ->take(1)
                           ->get();

        return $data_lists;
   }

}
