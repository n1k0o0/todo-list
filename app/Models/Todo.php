<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'name',
        'is_done'
    ];

    protected $casts = [
        'id' => 'integer',
        'is_done' => 'boolean',
    ];
}
