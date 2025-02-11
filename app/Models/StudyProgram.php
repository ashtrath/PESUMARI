<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyProgram extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function students()
    {
        return $this->users()->whereHas('roles', function ($query) {
            $query->where('name', 'mahasiswa');
        });
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
