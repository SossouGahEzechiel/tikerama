<?php

namespace Database\Factories;

use App\Enums\{EventCategoryEnum, EventStatusEnum};
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{

	public function definition(): array
	{
		return [
			'category' => fake()->randomElement(EventCategoryEnum::cases()),
			'image' => fake()->imageUrl(640, 480, 'events'),
			'city' => fake()->city,
			'status' => fake()->randomElement(EventStatusEnum::cases()),
			'title' => fake()->sentence,
			'description' => fake()->paragraph,
			'address' => fake()->address,
			'date' => fake()->dateTimeBetween('now', '+2 years'),
		];
	}
}
