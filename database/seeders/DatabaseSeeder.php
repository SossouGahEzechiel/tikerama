<?php

namespace Database\Seeders;

use App\Models\{Event, TicketType};
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
	public function run(): void
	{

		Event::factory()->count(100)->generateCode()->create()->each(fn($event) => TicketType::factory()
			->count(fake()->numberBetween(1, 5))
			->create(['event_id' => $event->id])
		);
	}
}
