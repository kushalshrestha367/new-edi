<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Counter extends Model implements Sortable
{
    use SortableTrait;

    protected $fillable = [
        'description',
        'counter',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'counter' => 'array'
    ]; // Critical for JSON fields

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true
    ];

    protected static function booted()
    {
        static::creating(fn($c) => $c->created_by = Auth::id());
        static::updating(fn($c) => $c->updated_by = Auth::id());
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
