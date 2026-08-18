<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Setup extends Model
{
    use HasFactory, HasSEO;
    
    protected $fillable = [
        'site_tagline',
        'primary_color',
        'secondary_color',
        'light_color',
        'dark_color',
        'footer_text',
        'maintenance_mode',
        'site_theme',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['logo_url'];

    protected static function booted()
    {
        static::creating(function ($setup) {
            $setup->created_by = Auth::id();
        });

        static::updating(function ($setup) {
            $setup->updated_by = Auth::id();
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

    public function getLogoUrlAttribute()
    {
        return optional(LibraryImage::find($this->logo_path))->getUrl('filament-thumbnail');
    }

    public static function getSetupData(Request $request){
        return Setup::first();
    }
}
