<?php

namespace Database\Seeders;

use App\Models\SpinWheel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpinWheelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SpinWheel::factory()->count(12)->create();
    }
}
