<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
	protected $model = Reservation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tomorrow = now()->addDay();
        $oneMonthFromNow = now()->addMonth();

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'number' => $this->faker->phoneNumber,
            'guest_count' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->dateTimeBetween($tomorrow, $oneMonthFromNow)->format('d/m/Y'), //format used in the form
            'time' => $this->faker->randomElement(['Lunch', 'Dinner']),
            'message' => $this->faker->paragraphs($this->faker->numberBetween(1, 5), true),
            'status' => null,
        ];
    }
}
