<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceHasExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'title',
        'description',
        'is_active',
        'sort_order',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
