<?php

namespace App\Filament\Resources\PrivateTableResource\Pages;

use App\Filament\Resources\PrivateTableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrivateTable extends EditRecord
{
    protected static string $resource = PrivateTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
