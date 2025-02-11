<?php

namespace App\Models;

use App\Enum\LetterStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class InternshipLetter extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'kaprodi_id',
        'officer_id',
        'letter_path',
        'status',
        'submission_date',
        'approval_date',
        'processing_date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function kaprodi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kaprodi_id');
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function updateStatus(LetterStatus $status, ?int $approverId = null): bool
    {
        return DB::transaction(function () use ($status, $approverId) {
            $this->status = $status;

            match ($status) {
                LetterStatus::APPROVED => $this->approval_date = now(),
                LetterStatus::PRINTED => $this->processing_date = now(),
                default => null,
            };

            if ($approverId) {
                match ($status) {
                    LetterStatus::APPROVED, LetterStatus::REJECTED => $this->kaprodi_id = $approverId,
                    LetterStatus::PRINTED => $this->officer_id = $approverId,
                    default => null,
                };
            }

            return $this->save();
        });
    }

    protected function casts(): array
    {
        return [
            'status' => LetterStatus::class,
            'submission_date' => 'datetime',
            'approval_date' => 'datetime',
            'processing_date' => 'datetime',
        ];
    }
}
