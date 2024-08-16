<?php

namespace App\Models;

use App\Enums\TicketStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle représentant un ticket d'événement.
 *
 * Ce modèle est utilisé pour stocker les informations relatives à un ticket d'événement,
 * telles que le statut, la commande associée et l'événement auquel il est lié.
 *
 * @package Tikerama-Test
 * @author SOSSOU-GAH Ézéchiel
 */
class Ticket extends Model
{
	/**
	 * Attributs qui ne peuvent pas être modifiés en masse.
	 *
	 * Le modèle autorise tous les attributs à être modifiables en masse.
	 *
	 * @var bool
	 */
	protected $guarded = false;

	/**
	 * Conversion automatique des attributs en types natifs PHP.
	 *
	 * Le champ 'status' est casté dans l'énumération "TicketStatusEnum".
	 *
	 * @var array
	 */
	protected $casts = [
		'status' => TicketStatusEnum::class
	];

	/**
	 * Relation BelongsTo avec le modèle "Order".
	 *
	 * Cette méthode définit la relation entre un ticket et sa commande associée.
	 *
	 * @return BelongsTo La relation avec le modèle "Order".
	 */
	public function order(): BelongsTo
	{
		return $this->belongsTo(Order::class);
	}

	/**
	 * Relation BelongsTo avec le modèle "Event".
	 *
	 * Cette méthode définit la relation entre un ticket et l'événement auquel il est lié.
	 *
	 * @return BelongsTo La relation avec le modèle "Event".
	 */
	public function event(): BelongsTo
	{
		return $this->belongsTo(Event::class);
	}
}
