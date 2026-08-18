<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsEvent extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'event_start_date',
        'event_end_date',
        'event_location',
        'image_path',
        'is_popup',
        'is_scroll',
        'is_published',
        'published_at',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'image_path' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($newsEvent) {
            $newsEvent->created_by = Auth::id();

            $newsEvent->slug = Str::slug($newsEvent->title) . '-' . rand(1000, 9999);

            if ($newsEvent->is_published && empty($newsEvent->published_at)) {
                $newsEvent->published_at = now();
            }
        });

        static::updating(function ($newsEvent) {
            $newsEvent->updated_by = Auth::id();

            if ($newsEvent->isDirty('title')) {
                $newsEvent->slug = Str::slug($newsEvent->title) . '-' . rand(1000, 9999);
            }

            $oldImages = $newsEvent->getOriginal('image_path') ?? [];
            $newImages = $newsEvent->image_path ?? [];
            $removedImages = array_diff($oldImages, $newImages);

            foreach ($removedImages as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        });

        static::deleting(function ($newsEvent) {
            if (!empty($newsEvent->image_path)) {
                foreach ($newsEvent->image_path as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        });

        static::saving(function ($model) {

            // if (!$model->slug) {
            //     $model->slug = Str::slug($model->title) . '-' . rand(1000, 9999);
            // }

            if (empty($model->image_path)) return;

            $newPaths = [];
            foreach ($model->image_path as $path) {
                $filename = basename($path);
                $newPath = "news_events/{$model->id}/gallery/{$filename}";

                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->move($path, $newPath);
                }

                $newPaths[] = $newPath;
            }

            $model->image_path = $newPaths;
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

    // ===== Custom Queries =====

    public static function getLatestNews($limit = 5)
    {
        return self::where('type', 'news')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('sort_order', 'DESC')
            ->orderBy('published_at', 'DESC')
            ->take($limit)
            ->get();
    }

    public static function getUpcomingEvents($limit = 5)
    {
        return self::where('type', 'event')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotNull('event_start_date')
            ->orderBy('event_start_date', 'ASC')
            ->take($limit)
            ->get();
    }

    public static function getPopupNews($limit = 5)
    {
        return self::where('type', 'news')
            ->where('is_published', true)
            ->where('is_popup', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('sort_order', 'DESC')
            ->orderBy('published_at', 'DESC')
            ->take($limit)
            ->get();
    }
}
