<?php

namespace App\Models;

use App\Enums\{EventCategoryEnum, EventStatusEnum};
use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\{Collection, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasManyThrough};

/**
 * @property Collection<array-key, TicketType> $ticketTypes
 * @property Collection<array-key, Order> $orders
 * @property Collection<array-key, Ticket> $tickets
 */
class Event extends Model
{
	use HasFactory, GenerateUniqueSlugTrait;

	protected $guarded = [
		'id',
		'slug',
		'created_at',
		'updated_at'
	];

	protected $casts = [
		'category' => EventCategoryEnum::class,
		'status' => EventStatusEnum::class,
		'date' => 'datetime'
	];

	public function ticketTypes(): HasMany
	{
		return $this->hasMany(TicketType::class);
	}

	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
	}

	public function tickets(): HasManyThrough
	{
		return $this->hasManyThrough(Ticket::class, TicketType::class);
	}
}
