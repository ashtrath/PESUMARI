<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum LetterStatus: string implements HasLabel, HasColor, HasIcon
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PRINTED = 'printed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Menunggu',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
            self::PRINTED => 'Dicetak',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'primary',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
            self::PRINTED => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDING => 'heroicon-m-clock',
            self::APPROVED => 'heroicon-m-check',
            self::REJECTED => 'heroicon-m-x-mark',
            self::PRINTED => 'heroicon-m-printer',
        };
    }
}
