<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int|null $daily_calorie_target
 * @property int|null $daily_protein_target
 * @property int|null $daily_carbs_target
 * @property int|null $daily_fat_target
 * @property int $id
 * @property bool $onboarded
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'sex',
        'height',
        'weight',
        'goal',
        'activity_level',
        'daily_calorie_target',
        'daily_protein_target',
        'daily_carbs_target',
        'daily_fat_target',
        'onboarded'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // custom functions

    // In User.php
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
