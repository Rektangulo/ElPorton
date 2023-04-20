<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
			'description' => $this->faker->sentences($nb = $this->faker->numberBetween(1, 4), $asText = true),
            'price' => $this->faker->randomFloat(2, 5, 20),
            'image_id' => $this->faker->numberBetween(9, 20),
			'category_id' => $this->faker->numberBetween(1, 7),
        ];
    }
}
