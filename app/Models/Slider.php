<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Http\Request;

class Slider extends Model
{
    use HasFactory;
    use SortableTrait;

    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'url',
        'is_active',
        'sort_order',
        'btn1_name',
        'btn1_link',
        'btn2_name',
        'btn2_link',
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
        static::creating(function ($slider) {
            $slider->created_by = Auth::id();
        });

        static::updating(function ($slider) {
            $slider->updated_by = Auth::id();
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

    public static function getSliderData(Request $request){
        return Slider::where('is_active', true)->get();
    }

}
