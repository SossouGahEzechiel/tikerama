<?php

namespace Database\Seeders;

use App\Models\{Event, TicketType};
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
	public function run(): void
	{
		/*User::factory()->create([
			'name' => 'Test User',
			'email' => 'test@example.com',
		]);*/
		Event::factory()->count(100)->create()->each(fn($event) => TicketType::factory()
			->count(fake()->randomNumber(1, 5))
			->create(['event_id' => $event->id]));
	}
}
