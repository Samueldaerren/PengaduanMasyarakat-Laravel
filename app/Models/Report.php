<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'type',
        'province',
        'regency',
        'subdistrict',
        'village',
        'voting',
        'votes',
        'viewers',
        'image',
        'statement',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke user (Inverse One to Many)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke responses (One to Many)
    public function responses()
    {
        return $this->hasMany(Response::class);
    }


    public function comments()
    {
    return $this->hasMany(Comment::class);
    }
}
