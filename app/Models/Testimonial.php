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
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'name',
        'designation',
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

    protected static function booted()
    {
        // When creating
        static::creating(function ($testimonial) {
            $testimonial->created_by = Auth::id();
            $testimonial->slug = Str::slug($testimonial->name) . '-' . rand(1000, 9999);
        });

        // When updating
        static::updating(function ($testimonial) {
            $testimonial->updated_by = Auth::id();

            // Regenerate slug if name changes
            if ($testimonial->isDirty('name')) {
                $testimonial->slug = Str::slug($testimonial->name) . '-' . rand(1000, 9999);
            }

            // Delete old image if replaced
            if ($testimonial->isDirty('image_path')) {
                $oldImage = $testimonial->getOriginal('image_path');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            // Delete old file if replaced (optional)
            if ($testimonial->isDirty('file_path')) {
                $oldFile = $testimonial->getOriginal('file_path');
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
        });

        // When deleting
        static::deleting(function ($testimonial) {
            if ($testimonial->image_path && Storage::disk('public')->exists($testimonial->image_path)) {
                Storage::disk('public')->delete($testimonial->image_path);
            }

            if ($testimonial->file_path && Storage::disk('public')->exists($testimonial->file_path)) {
                Storage::disk('public')->delete($testimonial->file_path);
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
}
