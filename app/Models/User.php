<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'institution_id',
        'student_number',
        'is_institutional',
        'is_active',
        'xp_points',
        'current_streak',
        'longest_streak',
        'last_active_date',
        'locale',
        'show_on_leaderboard',
        'accessibility_prefs',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_institutional' => 'boolean',
            'is_active' => 'boolean',
            'show_on_leaderboard' => 'boolean',
            'last_active_date' => 'date',
            'accessibility_prefs' => 'array',
        ];
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'owner_id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'lecturer_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledClassrooms()
    {
        return $this->belongsToMany(Classroom::class, 'enrollments', 'user_id', 'classroom_id')->withTimestamps();
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function writingSubmissions()
    {
        return $this->hasMany(WritingSubmission::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges', 'user_id', 'badge_id')->withPivot('awarded_at')->withTimestamps();
    }

    public function xpLogs()
    {
        return $this->hasMany(XpLog::class);
    }
}
