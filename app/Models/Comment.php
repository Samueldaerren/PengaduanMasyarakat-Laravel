<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id', 'comment','user_id'
    ];

    // Relasi ke report (Inverse One to Many)
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // Relasi ke user (Inverse One to Many)
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
