<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Str;

class Partner extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'title',
        'description',
        'link',
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
        static::creating(function ($partner) {
            $partner->created_by = Auth::id();
            $partner->slug = Str::slug($partner->title);
        });

        static::updating(function ($partner) {
            $partner->updated_by = Auth::id();

            if ($partner->isDirty('title')) {
                $partner->slug = Str::slug($partner->title);
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
}
