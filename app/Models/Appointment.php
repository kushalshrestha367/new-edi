<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Appointment extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'patient_name',
        'email',
        'phone',
        'appointment_date',
        'appointment_time',
        'department_has_item_id',
        'doctor_id',
        'notes',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public $sortable = ['order_column_name' => 'sort_order', 'sort_when_creating' => true];

    protected static function booted()
    {
        static::creating(function ($member) {
            $member->created_by = Auth::id();

            // Generate appointment code: initials + 6-digit random number
            $initials = collect(explode(' ', $member->patient_name))
                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                ->implode('');

            $randomNumber = mt_rand(100000, 999999);

            $member->appointment_code = $initials. '-' . $randomNumber;
        });

        static::updating(function ($member) {
            $member->updated_by = Auth::id();
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

    public function department()
    {
        return $this->belongsTo(DepartmentHasItem::class, 'department_has_item_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Member::class, 'doctor_id');
    }
}
