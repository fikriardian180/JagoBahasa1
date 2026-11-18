<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'title',
        'slug',
        'level',
        'category',
        'description',
        'thumbnail',
        'visibility',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order_number');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
