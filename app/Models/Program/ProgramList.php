<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Auth;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class ProgramList extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $table = 'program_lists';

    protected $fillable = [
        'program_category_id',
        'slug',
        'title',
        'short_form',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProgramCategory::class, 'program_category_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProgramHasFile::class, 'program_list_id');
    }

    public function activeFiles()
    {
        return $this->hasMany(ProgramHasFile::class)->where('is_active', 1);
    }

    public function inactiveFiles()
    {
        return $this->hasMany(ProgramHasFile::class)->where('is_active', 0);
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
