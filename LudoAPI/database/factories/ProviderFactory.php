<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Provider;
use App\Models\User;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'provider' => $this->faker->word(),
            'provider_id' => $this->faker->word(),
            'user_id' => User::factory(),
        ];
    }
}
