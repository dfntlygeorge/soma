<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuttingProgress extends Model
{
    //
    use HasFactory;

    protected $table = 'cutting_progress';

    protected $fillable = [
        'user_id',
        'started_at',
        'start_weight',
        'goal_weight',
        'current_weight',
        'duration_days',
        'milestones',
        'active',
    ];

    protected $casts = [
        'started_at' => 'date',
        'milestones' => 'array',
        'active' => 'boolean',
    ];

    // Optional: Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
