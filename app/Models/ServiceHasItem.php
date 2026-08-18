<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Support\Str;

class ServiceHasItem extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $fillable = [
        'service_id',
        'title',
        'icon',
        'description',
        'image_path',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::creating(function ($service_has_item) {
            $service_has_item->created_by = Auth::id();
            $service_has_item->slug = Str::slug($service_has_item->title);
        });

        static::updating(function ($service_has_item) {
            $service_has_item->updated_by = Auth::id();

            // Optional: update slug if title changes
            if ($service_has_item->isDirty('title')) {
                $service_has_item->slug = Str::slug($service_has_item->title);
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getImageUrlAttribute()
    {
        $imageId = $this->image_path;

        // if JSON or array, decode or get first
        if (is_string($imageId) && \Illuminate\Support\Str::startsWith($imageId, '[')) {
            $decoded = json_decode($imageId, true);
            $imageId = $decoded[0] ?? null;
        }

        return optional(LibraryImage::find($imageId))->getUrl('filament-thumbnail');
    }

    public static function getServiceHasItemData() {
        return ServiceHasItem::where('is_active', true)->orderBy('sort_order')->get();
    }

}
