<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Http\Request;

class Contact extends Model
{
    use HasFactory, HasSEO;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'fax',
        'address',
        'latitude',
        'longitude',
        'map',
        'created_by',
        'updated_by'
    ];

    protected static function booted()
    {
        static::creating(function ($contact) {
            $contact->created_by = Auth::id();
        });

        static::updating(function ($contact) {
            $contact->updated_by = Auth::id();
        });
    }

    public function socialMedia()
    {
        return $this->hasMany(ContactSocialMedia::class);
    }

    public function branches()
    {
        return $this->hasMany(ContactBranch::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function getContactData(Request $request){
        return Contact::with('socialMedia')->first();
    }
}
