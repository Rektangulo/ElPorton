<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContactMessage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
	protected $model = ContactMessage::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'number' => $this->faker->phoneNumber,
            'reason' => $this->faker->randomElement(['reservation', 'event', 'feedback', 'other']),
            'message' => $this->faker->paragraphs($this->faker->numberBetween(1, 5), true),
            'read' => false,
			'important' => false,
        ];
    }
}
