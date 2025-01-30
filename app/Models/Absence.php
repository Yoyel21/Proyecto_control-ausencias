<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'hour',
        'comment',
    ];

    // Cada ausencia pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
