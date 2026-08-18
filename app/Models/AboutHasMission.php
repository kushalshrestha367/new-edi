<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class AboutHasMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_us_id',
        'title',
        'icon',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $table = 'about_has_missions'; // Ensure correct table name

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
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