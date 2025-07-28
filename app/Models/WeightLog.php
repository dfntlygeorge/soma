<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WeightLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'weight',
        'change',
        'total_lost',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'weight' => 'decimal:2',
        'change' => 'decimal:2',
        'total_lost' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope to get entries for a specific user
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope to get recent entries
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('date', '>=', Carbon::now()->subDays($days));
    }

    // Get the latest entry for a user
    public static function getLatestForUser($userId)
    {
        return static::forUser($userId)->orderBy('date', 'desc')->first();
    }

    // Get entries for a specific date range
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}
