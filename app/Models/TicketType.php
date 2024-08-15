<?php

namespace App\Models;

use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle pour représenter un type de ticket pour un événement dans l'application.
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $event_id
 * @property int $quantity
 * @property int $price
 */
class TicketType extends Model
{
	use HasFactory, GenerateUniqueSlugTrait;

	public $timestamps = false;

	protected $guarded = ['id', 'slug'];

	protected $casts = [
		'price' => 'integer'
	];

	/**
	 * Retourne l'évènement auquel est lié le type de tickets.
	 *
	 * @return BelongsTo La relation BelongsTo.
	 */
	public function event(): BelongsTo
	{
		return $this->belongsTo(Event::class);
	}
}
