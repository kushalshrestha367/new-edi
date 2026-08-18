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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Member extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $fillable = [
        'name',
        'designation',
        'nmc_number',
        'phone',
        'email',
        'fax',
        'address',
        'image_path',
        'show_first',
        'has_appointment',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    public $sortable = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::creating(function ($member) {
            $member->created_by = Auth::id();
            $member->slug = Str::slug($member->name);
        });

        static::updating(function ($member) {
            $member->updated_by = Auth::id();

            if ($member->isDirty('name')) {
                $member->slug = Str::slug($member->name);
            }
        });
    }

    public function getImageUrlAttribute(): ?string
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

    /**
     * Get all active + show_first members, ordered by sort_order
     */
    public static function getActiveMembers($onlyFirst = false)
    {
        $query = self::where('is_active', true)->orderBy('sort_order');

        if ($onlyFirst) {
            $query->where('show_first', true);
        }

        return $query->get();
    }
}
