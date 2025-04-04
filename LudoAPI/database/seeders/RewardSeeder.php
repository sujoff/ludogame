<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Reward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = Collection::pluck('id');
        for($i = 1; $i <= 3; $i++) {
            for ($j = 0; $j <= 6; $j++) {
                Reward::factory()->create([
                    'collection_id' => $collections->random(),
                    'day' => $j
                ]);
            }
        }
    }
}
