<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Auth;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Support\Str;

class Department extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $fillable = [
        'title',
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
        static::creating(function ($department) {
            $department->created_by = Auth::id();
            $department->slug = Str::slug($department->title);
        });

        static::updating(function ($department) {
            $department->updated_by = Auth::id();

            // Optional: update slug if title changes
            if ($department->isDirty('title')) {
                $department->slug = Str::slug($department->title);
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

    public function items()
    {
        return $this->hasMany(DepartmentHasItem::class);
    }

}
