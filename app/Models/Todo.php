<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'task',
        'is_completed',
        'due_at',
        'google_event_id',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'due_at' => 'datetime',
    ];
}
