<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'content_text',
        'audio_url',
        'transcript',
        'vocabulary',
        'speaking_target_phrase',
        'grammar_prompt',
        'xp_reward',
        'order_number',
    ];

    protected function casts(): array
    {
        return [
            'vocabulary' => 'array',
        ];
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function writingSubmissions()
    {
        return $this->hasMany(WritingSubmission::class);
    }
}
