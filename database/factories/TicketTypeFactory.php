<?php

namespace Database\Factories;

use App\Models\{Event, TicketType};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketType>
 */
class TicketTypeFactory extends Factory
{

	public function definition(): array
	{
		return [
			'name' => $this->faker->word,
			'event_id' => Event::factory(),
			'quantity' => $this->faker->numberBetween(1, 10),
			'price' => $this->faker->randomElement([2_000, 5_000, 7_500, 10_000, 25_000, 50_000, 85_000]),
			'description' => $this->faker->sentence,
		];
	}
}
