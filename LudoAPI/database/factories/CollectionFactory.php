<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Collection;

class CollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Collection::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(["board","dice","emote","token"]),
            'image' => $this->faker->imageUrl(),
            'cost' => $this->faker->randomFloat(0, 0, 999),
            'currency_type' => $this->faker->randomElement(["COIN","GEM","ADS"]),
            'code' => $this->faker->unique()->ean8(),
            'status' => $this->faker->randomElement(["active","inactive"]),
        ];
    }
}
