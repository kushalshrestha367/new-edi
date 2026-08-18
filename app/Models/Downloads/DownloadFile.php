<?php

namespace App\Models\Downloads;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Auth;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class DownloadFile extends Model implements Sortable
{
    use HasFactory, SortableTrait, HasSEO;

    protected $table = 'download_files';

    protected $fillable = [
        'download_id',
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

    public function download(): BelongsTo
    {
        return $this->belongsTo(Download::class, 'download_id');
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
