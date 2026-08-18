<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Auth;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProgramHasFile extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $table = 'program_has_files';

    protected $fillable = [
        'program_list_id',
        'file_name',
        'file_path',
        'file_type',
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
        });

        static::updating(function ($model) {

            // If file_path is changed, delete old file
            if ($model->isDirty('file_path')) {
                $oldPath = $model->getOriginal('file_path');

                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {

            // Delete file when record is deleted
            $path = $model->file_path;

            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        });
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramList::class, 'program_list_id');
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
