<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class GalleryImage extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'gallery_id',
        'image_path',
        'caption',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected static function booted()
    {
        static::creating(function ($gallery_image) {
            $gallery_image->created_by = Auth::id();
        });

        static::updating(function ($gallery_image) {
            $gallery_image->updated_by = Auth::id();
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public static function getGalleryImageDetail()
    {
        $query = GalleryImage::where('is_active', true);

        if ($query->count() > 9) {
            return $query->inRandomOrder()->take(5)->get();
        }

        return $query->orderBy('id', 'DESC')->take(5)->get();
    }
}
