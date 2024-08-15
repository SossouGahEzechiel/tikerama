<?php

namespace App\Models;

use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property string $slug
 * @property string $id
 */
class Order extends Model
{

	use GenerateUniqueSlugTrait;

	public function hasSlugBaseKeyProvider(): bool
	{
		return false;
	}

	protected $guarded = ['slug', 'created_at', 'updated_at'];

	public function event(): BelongsTo
	{
		return $this->belongsTo(Event::class);
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

	public function tickets(): HasMany
	{
		return $this->hasMany(Ticket::class);
	}
}
