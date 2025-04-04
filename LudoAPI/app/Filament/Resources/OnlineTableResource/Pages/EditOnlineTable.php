<?php

namespace App\Filament\Resources\OnlineTableResource\Pages;

use App\Filament\Resources\OnlineTableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOnlineTable extends EditRecord
{
    protected static string $resource = OnlineTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
