<?php

namespace App\Models\Downloads;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class Download extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $table = 'downloads';

    protected $fillable = [
        'slug',
        'title',
        'short_description',
        'description',
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
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->slug = Str::slug($model->title);
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();

            if ($model->isDirty('title')) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function files(): HasMany
    {
        return $this->hasMany(DownloadFile::class, 'download_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function getDownloadDatas() {
        return Download::where('is_active', true)->orderBy('sort_order')->get();
    }
}
