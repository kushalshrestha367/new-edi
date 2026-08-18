<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Support\Str;

class WhyChooseUs extends Model
{

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::creating(function ($whyChooseUs) {
            $whyChooseUs->created_by = Auth::id();
            $whyChooseUs->slug = Str::slug($whyChooseUs->title);
        });

        static::updating(function ($whyChooseUs) {
            $whyChooseUs->updated_by = Auth::id();

            if ($whyChooseUs->isDirty('title')) {
                $whyChooseUs->slug = Str::slug($whyChooseUs->title);
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
