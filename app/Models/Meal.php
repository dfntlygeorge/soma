<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;
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
        'category',
        'saved_meal_id'
    ];
}
