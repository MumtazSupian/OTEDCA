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
        $r = strtolower($this->attributes['role'] ?? '');
        if (in_array($r, [
            'adh', 'adh bp', 'adh_bp', 'ho_unit', 'bm_sh',
            'service manager', 'service_manager', 'servicemanager', 'sm',
            'service advisor', 'service_advisor', 'serviceadvisor', 'sa',
            'service admin', 'service_admin', 'serviceadmin', 'adm_service',
        ]) || str_contains($r, 'adh') || str_contains($r, 'service')) {
            return false;
        }
        if (array_key_exists('is_admin', $this->attributes) && $this->attributes['is_admin']) {
            return true;
        }
        $email = strtolower($this->attributes['email'] ?? '');
        return in_array($r, ['admin', 'om', 'it', 'admin dca', 'om dca']) || in_array($email, ['dcasr', 'it', 'heruit', 'mumtazit', 'rizkyit']);
    }

    public function getIsAdminStockAttribute()
    {
        if (array_key_exists('is_admin_stock', $this->attributes) && $this->attributes['is_admin_stock']) {
            return true;
        }
        $r = strtolower($this->attributes['role'] ?? '');
        $email = strtolower($this->attributes['email'] ?? '');
        return in_array($r, ['ho_unit', 'admin_stock', 'stock']) || $email === 'dcahounit';
    }

    public function getIsAdhAttribute()
    {
        $r = strtolower($this->attributes['role'] ?? '');
        $email = strtolower($this->attributes['email'] ?? '');
        $branch = strtolower($this->attributes['branch'] ?? '');
        return str_contains($r, 'adh') || in_array($r, ['adh', 'adh bp', 'adh_bp']) || str_contains($email, 'adh') || $branch === 'bp';
    }

    public function getIsServiceAttribute()
    {
        $r = strtolower(trim($this->attributes['role'] ?? ''));
        $email = strtolower(trim($this->attributes['email'] ?? ''));
        
        $serviceRoles = [
            'service manager', 'service_manager', 'servicemanager', 'sm',
            'service advisor', 'service_advisor', 'serviceadvisor', 'sa',
            'service admin', 'service_admin', 'serviceadmin', 'adm_service',
            'service',
        ];

        if (in_array($r, $serviceRoles) || str_contains($r, 'service')) {
            return true;
        }

        // Email matching: dcacwismits, dcacjrsa1, dcacwisa1, etc.
        if (str_ends_with($email, 'sm') || str_contains($email, 'smits') || preg_match('/(sa\d*|sm\d*)$/', $email)) {
            return true;
        }

        return false;
    }

    public function getCanAccessFinanceAttribute()
    {
        return $this->is_admin || ($this->role ?? '') === 'om' || $this->is_adh || ($this->branch ?? '') === 'bp' || $this->is_service;
    }

    public function getIsItAttribute()
    {
        $email = strtolower(trim($this->email ?? $this->attributes['email'] ?? ''));
        if ($email === 'dcasr') {
            return false;
        }

        $r = strtolower(trim($this->role ?? $this->attributes['role'] ?? ''));
        $name = strtolower(trim($this->name ?? $this->attributes['name'] ?? ''));
        return in_array($r, ['it', 'admin', 'superadmin', 'admin dca']) 
            || str_contains($r, 'it') 
            || str_contains($email, 'it')
            || str_contains($name, 'it')
            || in_array($email, ['it', 'heruit', 'mumtazit', 'rizkyit'])
            || in_array($name, ['it', 'heruit', 'mumtazit', 'rizkyit', 'mumtaz'])
            || (!empty($this->is_admin))
            || (!empty($this->attributes['is_admin']) && $this->attributes['is_admin']);
    }
}

