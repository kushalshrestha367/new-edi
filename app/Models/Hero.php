<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Storage;

class Hero extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'institution_name',
        'institution_short_name',
        'description',
        'cta_label',
        'cta_url',
        'show_video_button',
        'video_url',
        'video_title',
        'bg_image_left',
        'bg_image_right',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    /**
     * Configure sortable behavior.
     */
    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * Boot the model to handle automatic user tracking.
     */
    protected static function booted()
    {
        static::creating(function ($hero) {
            $hero->created_by = Auth::id();
        });

        static::updating(function ($hero) {
            $hero->updated_by = Auth::id();

            // Delete old left image
            if ($hero->isDirty('bg_image_left')) {
                $oldImage = $hero->getOriginal('bg_image_left');

                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            // Delete old right image
            if ($hero->isDirty('bg_image_right')) {
                $oldImage = $hero->getOriginal('bg_image_right');

                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        });

        static::deleting(function ($hero) {

            if ($hero->bg_image_left && Storage::disk('public')->exists('hero/' . $hero->bg_image_left)) {
                Storage::disk('public')->delete('hero/' . $hero->bg_image_left);
            }

            if ($hero->bg_image_right && Storage::disk('public')->exists('hero/' . $hero->bg_image_right)) {
                Storage::disk('public')->delete('hero/' . $hero->bg_image_right);
            }
        });
    }

    /**
     * Relationship: The user who created this hero section.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship: The user who last updated this hero section.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
