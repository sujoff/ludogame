<?php

namespace App\Filament\Resources\OnlineTableResource\Pages;

use App\Filament\Resources\OnlineTableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOnlineTables extends ListRecords
{
    protected static string $resource = OnlineTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
