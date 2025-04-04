<?php

namespace App\Filament\Resources\OnlineTableResource\Pages;

use App\Filament\Resources\OnlineTableResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOnlineTable extends ViewRecord
{
    protected static string $resource = OnlineTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
