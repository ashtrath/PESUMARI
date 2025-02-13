<?php

namespace App\Models;

use App\Enum\LetterStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class InternshipLetter extends Model
{
    public const CREATED_AT = 'submission_date';

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

    public function updateStatus(LetterStatus $status, int $approverId, ?string $reason = null): bool
    {
        return DB::transaction(function () use ($status, $approverId, $reason) {
            $this->status = $status;

            switch ($status) {
                case LetterStatus::APPROVED:
                    $this->approval_date = now();
                    $this->kaprodi_id = $approverId;
                    break;

                case LetterStatus::PRINTED:
                    $this->processing_date = now();
                    $this->officer_id = $approverId;
                    break;

                case LetterStatus::REJECTED:
                    $this->kaprodi_id = $approverId;
                    if (empty($reason)) {
                        throw new InvalidArgumentException('A rejection reason is required when rejecting a letter.');
                    }
                    $this->comments()->create(['comment' => $reason, 'user_id' => $approverId]);
                    break;

                default:
                    break;
            }

            return $this->save();
        });
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'letter_id');
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
