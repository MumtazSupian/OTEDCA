<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        ];
    }

    public function targetDoUnits()
    {
        return $this->hasMany(\App\Models\rka\TargetDoUnit::class, 'user_id', 'id');
    }

    public function targetInquiries()
    {
        return $this->hasMany(\App\Models\rka\TargetInquiry::class, 'user_id', 'id');
    }

    public function targetDoBySois()
    {
        return $this->hasMany(\App\Models\rka\TargetDoBySoi::class, 'user_id', 'id');
    }

    public function actualSalesByLeasing()
    {
        return $this->hasMany(\App\Models\current\ActualSalesByLeasing::class, 'user_id');
    }

    public function actualDoByTypes()
    {
        return $this->hasMany(\App\Models\current\ActualDoByType::class, 'user_id', 'id');
    }

    public function actualSpkByTypes()
    {
        return $this->hasMany(\App\Models\current\ActualSpkByType::class, 'user_id', 'id');
    }

    public function actualInquaryByTypes()
    {
        return $this->hasMany(\App\Models\current\ActualInquaryByType::class, 'user_id', 'id');
    }

    public function actualSourceInquaries()
    {
        return $this->hasMany(\App\Models\current\ActualSourceInquary::class, 'user_id', 'id');
    }

    public function actualSourceDoInquaries()
    {
        return $this->hasMany(\App\Models\current\ActualSourceDoInquary::class, 'user_id', 'id');
    }

    public function actualSalesForces()
    {
        return $this->hasMany(\App\Models\current\ActualSalesForce::class, 'user_id', 'id');
    }

    public function actualDoSalesforces()
    {
        return $this->hasMany(\App\Models\current\ActualDoSalesforce::class, 'user_id', 'id');
    }

}
