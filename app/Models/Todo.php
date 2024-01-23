<?php

namespace App\Models;

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

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(static function ($model) {
            $model->user_id = auth('users')->id();
        });
    }

}
