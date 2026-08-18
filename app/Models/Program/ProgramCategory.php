<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Auth;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Support\Str;
use App\Models\Program\ProgramList;
use App\Models\User;

class ProgramCategory extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $table = 'program_categories';

    protected $fillable = [
        'slug',
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
        static::creating(function ($category) {
            $category->created_by = Auth::id();
            $category->slug = Str::slug($category->title);
        });

        static::updating(function ($category) {
            $category->updated_by = Auth::id();

            if ($category->isDirty('title')) {
                $category->slug = Str::slug($category->title);
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

    public function programs()
    {
        return $this->hasMany(ProgramList::class, 'program_category_id');
    }
}
