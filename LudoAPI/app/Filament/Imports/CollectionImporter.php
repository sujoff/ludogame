<?php

namespace App\Filament\Imports;

use App\Models\Collection;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CollectionImporter extends Importer
{
    protected static ?string $model = Collection::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('type')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('cost')
                ->requiredMapping()
                ->numeric()
                ->rules(['required','integer']),
            ImportColumn::make('amount')
                ->requiredMapping()
                ->numeric()
                ->rules(['required','integer']),
            ImportColumn::make('currency_type')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('category')
                ->requiredMapping()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?Collection
    {
        dd($this->data);
         return Collection::firstOrNew([
             // Update existing records, matching them by `$this->data['column_name']`
             'code' => $this->data['code'],
         ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your collection import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
