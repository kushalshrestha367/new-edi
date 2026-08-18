<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Str;

class Gallery extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'slug',
        'title',
        'description',
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
        static::creating(function ($gallery) {
            $gallery->created_by = Auth::id();
            $gallery->slug = Str::slug($gallery->title) . '-' . rand(1000, 9999);
        });

        static::updating(function ($gallery) {
            $gallery->updated_by = Auth::id();

            if ($gallery->isDirty('title')) {
                $gallery->slug = Str::slug($gallery->title) . '-' . rand(1000, 9999);
            }
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
}
