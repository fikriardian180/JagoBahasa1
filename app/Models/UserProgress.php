<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'status',
        'speaking_score',
        'quiz_score',
        'writing_score',
        'attempts',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'speaking_score' => 'decimal:2',
            'quiz_score' => 'decimal:2',
            'writing_score' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
