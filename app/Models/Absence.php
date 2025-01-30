<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'date',
        'hour',
        'comment',
    ];

    // Cada ausencia pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function canEditOrDelete()
    {
        return auth()->user()->is_admin || $this->created_at->diffInMinutes(Carbon::now()) < 10;
    }
}
