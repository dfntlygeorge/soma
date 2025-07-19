<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $casts = [
        'date' => 'date',
    ];

    protected $fillable = [
        'user_id',
        'description',
        'total_calories',
        'protein',
        'carbs',
        'fat',
        'date',
        'category'
    ];
}
