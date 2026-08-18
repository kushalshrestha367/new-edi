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

class DepartmentHasItem extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $fillable = [
        'department_id',
        'title',
        'description',
        'image_path',
        'has_appointment',
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
        static::creating(function ($department_has_item) {
            $department_has_item->created_by = Auth::id();
            $department_has_item->slug = Str::slug($department_has_item->title);
        });

        static::updating(function ($department_has_item) {
            $department_has_item->updated_by = Auth::id();

            // Optional: update slug if title changes
            if ($department_has_item->isDirty('title')) {
                $department_has_item->slug = Str::slug($department_has_item->title);
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Instead of just ->where('is_active', true)
    public function members()
    {
        return $this->belongsToMany(Member::class, 'department_members', 'department_has_item_id', 'member_id')
            ->withPivot('show_first', 'is_active', 'sort_order')
            ->orderBy('pivot_sort_order', 'asc');
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
}
