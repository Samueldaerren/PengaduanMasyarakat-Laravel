<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id', 'histories',
    ];

    protected $casts = [
        'histories' => 'array',
    ];

    // Relasi ke response (Inverse One to Many)
    public function response()
    {
        return $this->belongsTo(Response::class);
    }
}
