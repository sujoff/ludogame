<?php

namespace App\Filament\Resources\CollectionResource\Pages;

use App\Filament\Imports\CollectionImporter;
use App\Filament\Resources\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCollections extends ManageRecords
{
    protected static string $resource = CollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
            ->importer(CollectionImporter::class),
        ];
    }
}
