<?php

namespace App\Models;

use App\Enums\{EventCategoryEnum, EventStatusEnum};
use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\{Collection, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasManyThrough};
use Illuminate\Support\Str;

/**
 * Modèle pour représenter un événement dans l'application.
 * Ses "property" permettent simplement d'avoir une meilleure auto-completion de l'IDE #phpstorm
 * @property Collection<array-key, Order> $orders
 * @property Collection<array-key, Ticket> $tickets
 * @property Collection<array-key, TicketType> $ticketTypes
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

	/**
	 * Les attributs qui doivent être convertis en types natifs ou customs.
	 *
	 * @var array
	 */
	protected $casts = [
		'category' => EventCategoryEnum::class,
		'status' => EventStatusEnum::class,
		'date' => 'datetime'
	];

	/**
	 * Retourne la relation HasMany avec le modèle TicketType.
	 *
	 * @return HasMany La relation HasMany.
	 */
	public function ticketTypes(): HasMany
	{
		return $this->hasMany(TicketType::class);
	}

	/**
	 * Retourne le prix le plus bas parmi tous les types de tickets associés à l'événement.
	 *
	 * @return null|int Le prix le plus bas ou null si aucun type de ticket n'est associé à l'événement.
	 */
	public function getLowerTicketPrice(): null|int
	{
		return $this->ticketTypes()->pluck('price')->min();
	}

	/**
	 * Retourne les commandes liées à l'évènement.
	 *
	 * @return HasMany La relation HasMany.
	 */
	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
	}

	/**
	 * Retourne les types de tickets liés à l'évènement au travers de ses tickets vendus.
	 *
	 * @return HasManyThrough La relation HasManyThrough.
	 */
	public function tickets(): HasManyThrough
	{
		return $this->hasManyThrough(Ticket::class, TicketType::class);
	}

	/**
	 * Génère un code de recherche unique pour l'événement sur la base de son id.
	 * On complète simplement l'id de l'évènement par suite de caractères aléatoires
	 * générées par Laravel jusqu'à atteindre 5 caractères. La suite est mise en majuscule
	 * pour que ce soit plus présentable aux utilisateurs
	 *
	 * @return self L'instance de l'événement ; comme tous bons setters.
	 */
	public function setCode(): self
	{
		$this->update(['code' => $this->id . str(Str::random(5 - str($this->id)->length()))->upper()]);
		return $this;
	}
}
