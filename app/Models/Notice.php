<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Support\Facades\Auth;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Notice extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'title',
        'type',
        'description',
        'date_show',
        'file_path',
        'image_path',
        'is_scroll',
        'is_popup',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    // protected $appends = ['image_url'];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected static function booted()
    {
        static::creating(function ($notice) {
            $notice->created_by = Auth::id();
            $notice->slug = Str::slug($notice->title) . '-' . rand(1000, 9999);
            $notice->sort_order = (static::max('sort_order') ?? 0) + 1;
        });

        static::updating(function ($notice) {
            $notice->updated_by = Auth::id();

            if ($notice->isDirty('title')) {
                $notice->slug = Str::slug($notice->title) . '-' . rand(1000, 9999);
            }

            if ($notice->isDirty('image_path')) {
                $oldImage = $notice->getOriginal('image_path');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            if ($notice->isDirty('file_path')) {
                $oldFile = $notice->getOriginal('file_path');
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
        });

        static::deleting(function ($notice) {
            if ($notice->file_path && Storage::disk('public')->exists($notice->file_path)) {
                Storage::disk('public')->delete($notice->file_path);
            }
            if ($notice->image_path && Storage::disk('public')->exists($notice->image_path)) {
                Storage::disk('public')->delete($notice->image_path);
            }
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

    public static function getNoticeData(Request $request){
        $data_listed = Notice::where('is_active', true)
                                ->where('is_scroll', true)
                                ->orderBy('sort_order', 'DESC')
                                ->orderBy('id', 'DESC')
                                ->take(5)
                                ->get();
        return $data_listed;
    }

    public static function getNoticeLatestList(Request $request){
        $data_listed = Notice::where('is_active', true)
                                ->orderBy('sort_order', 'DESC')
                                ->orderBy('id', 'DESC')
                                ->take(5)
                                ->get();
        return $data_listed;
    }

    public static function getNoticePopList(Request $request){
        $data_listed = Notice::where('is_active', true)
                                ->where('is_popup', true)
                                ->orderBy('sort_order', 'DESC')
                                ->orderBy('id', 'DESC')
                                ->take(5)
                                ->get();
        return $data_listed;
    }
}
