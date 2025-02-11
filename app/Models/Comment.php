<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'letter_id',
        'user_id',
        'comment',
    ];

    public function letter(): BelongsTo
    {
        return $this->belongsTo(InternshipLetter::class, 'letter_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
