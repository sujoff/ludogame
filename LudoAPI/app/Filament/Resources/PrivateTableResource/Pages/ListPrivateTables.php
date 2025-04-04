<?php

namespace App\Filament\Resources\PrivateTableResource\Pages;

use App\Filament\Resources\PrivateTableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrivateTables extends ListRecords
{
    protected static string $resource = PrivateTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
