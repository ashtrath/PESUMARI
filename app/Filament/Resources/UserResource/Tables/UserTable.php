<?php

namespace App\Filament\Resources\UserResource\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;

class UserTable extends TableBuilder
{
    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('email')
                ->searchable(),
            TextColumn::make('roles.name')
                ->label('Role')
                ->formatStateUsing(fn($state): string => Str::headline($state))
                ->colors(['info'])
                ->badge(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
            ->actions([
                EditAction::make()->hiddenLabel()->tooltip('Edit'),
                DeleteAction::make()->hiddenLabel()->tooltip('Delete')
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
