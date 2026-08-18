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

class Team extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $fillable = [
        'name',
        'designation',
        'academic',
        'message',
        'bio',
        'image_path',
        'has_message',
        'on_menu',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by'
    ];

    public $sortable = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    protected $appends = ['image_url'];

    protected static function booted()
    {
        static::creating(function ($team) {
            $team->created_by = Auth::id();
            $team->slug = Str::slug($team->name);
        });

        static::updating(function ($team) {
            $team->updated_by = Auth::id();

            if ($team->isDirty('name')) {
                $team->slug = Str::slug($team->name);
            }
        });
    }

    public function getImageUrlAttribute(): ?string
    {
        return optional(LibraryImage::find($this->image_path))->getUrl('filament-thumbnail');
    }

    public function media(): HasMany
    {
        return $this->hasMany(TeamHasMedia::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function getTeamData(){
        return Team::where('is_active', true)
                    ->where('on_menu', true)
                    // ->where('has_message', true)
                    ->orderBy('sort_order')
                    ->get();
    }
}
