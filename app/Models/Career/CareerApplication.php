<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class CareerApplication extends Model
{
    use HasFactory;

    protected $table = 'career_applications';

    protected $fillable = [
        'career_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'resume_path',
        'is_active',
        'updated_by',
    ];

    protected static function booted()
    {
        static::updating(function ($model) {

            // If resume_path is changed, delete old file
            if ($model->isDirty('resume_path')) {
                $oldPath = $model->getOriginal('resume_path');

                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {

            // Delete resume file when record is deleted
            $path = $model->resume_path;

            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        });
    }

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
