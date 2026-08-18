<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class ContactBranch extends Model
{
    use SortableTrait;
    
    protected $fillable = [
        'contact_id',
        'name',
        'email',
        'phone',
        'fax',
        'address',
        'latitude',
        'longitude',
        'sort_order'
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
