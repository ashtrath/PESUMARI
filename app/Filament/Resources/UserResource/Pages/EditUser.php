<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function afterSave(): void
    {
        if ($this->data['role'] ?? null) {
            $this->record->assignRole($this->data['role']);
        }
    }

    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
