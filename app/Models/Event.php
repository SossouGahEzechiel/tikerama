<?php

namespace App\Models;

use App\Enums\{EventCategoryEnum, EventStatusEnum};
use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\{Collection, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasManyThrough};
use Illuminate\Support\Str;

/**
 * @property Collection<array-key, TicketType> $ticketTypes
 * @property Collection<array-key, Order> $orders
 * @property Collection<array-key, Ticket> $tickets
 * @property string $slug
 * @property string $id
 */
class Event extends Model
{
	use HasFactory, GenerateUniqueSlugTrait;

	public function getSlugBaseKeyName(): string
	{
		return "title";
	}

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


	public function getLowerTicketPrice(): null|int
	{
		return $this->ticketTypes()->pluck('price')->min();
	}

	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
	}

	public function tickets(): HasManyThrough
	{
		return $this->hasManyThrough(Ticket::class, TicketType::class);
	}

	public function setCode(): self
	{
		$this->update(['code' => $this->getAttribute('id') . str(Str::random(5 - str($this->id)->length()))->upper()]);
		return $this;
	}
}
