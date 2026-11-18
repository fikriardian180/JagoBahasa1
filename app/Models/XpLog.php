<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XpLog extends Model
{
    use HasFactory;

    protected $table = 'xp_logs';

    protected $fillable = [
        'user_id',
        'source',
        'points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
