<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'branch',
        'is_admin',
        'is_admin_stock',
        'role',
        'cabang',
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
            'is_admin' => 'boolean',
            'is_admin_stock' => 'boolean',
        ];
    }

    public function getIsAdminAttribute()
    {
        if (array_key_exists('is_admin', $this->attributes) && $this->attributes['is_admin']) {
            return true;
        }
        $r = strtolower($this->attributes['role'] ?? '');
        return in_array($r, ['admin', 'om', 'admin dca', 'om dca', 'bm', 'user']) || empty($r);
    }
}
