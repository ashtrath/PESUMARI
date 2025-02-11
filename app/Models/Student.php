<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'nim';

    protected $fillable = [
        'nim',
        'gender',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
