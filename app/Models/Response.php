<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id', 'response_status', 'staff_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke report (Inverse One to Many)
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // Relasi ke user (Inverse One to Many)
    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    // Relasi ke response_progress (One to Many)
    public function responseProgress()
    {
        return $this->hasMany(ResponseProgress::class);
    }
}   