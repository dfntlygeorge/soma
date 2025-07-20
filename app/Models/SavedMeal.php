<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedMeal extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'calories',
        'protein',
        'carbs',
        'fat',
    ];
}
