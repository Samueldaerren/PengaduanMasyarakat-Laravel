<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke staff_province (One to One)
    public function staffProvince()
    {
        return $this->hasOne(StaffProvince::class);
    }

    // Relasi ke report (One to Many)
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Relasi ke comment (One to Many)
        public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke response (One to Many)
    public function responses()
    {
        return $this->hasMany(Response::class, 'staff_id');
    }
}