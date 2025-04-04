<?php

namespace Database\Seeders;

use App\Enums\ActionStatusEnum;
use App\Models\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Random\RandomException;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        $import = File::json(storage_path('imports/economy.txt'));

        foreach ($import as $type => $items) {
            foreach ($items as $item) {
                Collection::create([
                    'type' => $item['ItemCategory'],
                    'code' => $item['ItemId'],
                    'image' => $item['ItemId'],
                    'currency_type' => $item['CurrencyType'],
                    'cost' => $item['ItemCost'],
                    'status' => ActionStatusEnum::ACTIVE,
                    'amount' => random_int(1, 100)
                ]);
            }
        }
    }
}
