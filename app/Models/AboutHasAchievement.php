<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class AboutHasAchievement extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'about_us_id',
        'title',
        'icon',
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
        static::creating(function ($achievement) {
            $achievement->created_by = Auth::id();
        });

        static::updating(function ($achievement) {
            $achievement->updated_by = Auth::id();
        });
    }

    public function aboutUs(): BelongsTo
    {
        return $this->belongsTo(AboutUs::class);
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