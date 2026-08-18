<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Auth;
use Outerweb\ImageLibrary\Models\Image as LibraryImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class TeamHasMedia extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = ['team_id', 'platform', 'url', 'is_active', 'sort_order'];

    public $sortable = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

}
