<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Firefly\FilamentBlog\Traits\HasBlog;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasBlog;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // Simple: allow all logged-in users
        return true;

        // Or restrict by role, email, etc.
        // return $this->hasRole('admin');
        // return $this->email === 'admin@example.com';
    }

    public function canComment(): bool
    {
        // Always allow logged-in users to comment
        // You can change the logic to check roles, permissions, etc.
        return true;

        // Example with role check:
        return $this->hasRole('commenter');
    }
}
