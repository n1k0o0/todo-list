<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'name',
        'is_done',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'is_done' => 'boolean',
        'user_id' => 'integer',
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

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOwn(Builder $query): Builder
    {
        return $query->where('user_id', auth('users')->id());
    }

}
