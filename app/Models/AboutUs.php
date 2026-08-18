<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne; 
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Support\Facades\Auth;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class AboutUs extends Model
{
    use HasFactory, HasSEO;

    protected $table = 'about_us'; // Explicitly define table name

    protected $fillable = [
        'title',
        'description',
        'short_description',
        'image_path',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        // 'achievements' => 'array', // REMOVE THIS LINE
        'our_values' => 'array',
        'our_mission' => 'array',
        'our_vision' => 'array',
    ];

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::creating(function ($aboutUs) {
            $aboutUs->created_by = Auth::id();
        });

        static::updating(function ($aboutUs) {
            $aboutUs->updated_by = Auth::id();
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

    // Define the new relationship for achievements
    public function achievements(): HasMany
    {
        return $this->hasMany(AboutHasAchievement::class, 'about_us_id');
    }

    public function mission(): HasOne
    {
        return $this->hasOne(AboutHasMission::class);
    }

    public function values(): HasOne
    {
        return $this->hasOne(AboutHasValue::class);
    }

    public function vision(): HasOne
    {
        return $this->hasOne(AboutHasVision::class);
    }
}