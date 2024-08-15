<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ressource pour représenter un type de ticket dans l'API.
 */
class TicketTypeResource extends JsonResource
{

	/**
	 * Transforme la ressource en un tableau associatif.
	 *
	 * @param Request $request La requête HTTP entrante.
	 * @return array Le tableau associatif représentant la ressource.
	 */
	public function toArray(Request $request): array
	{
		return [
			'name' => $this->resource->name, // Le nom du type de ticket.
			'slug' => $this->resource->slug, // Le slug unique du type de ticket.
			'price' => $this->resource->price, // Le prix du type de ticket.
			'quantity' => $this->resource->quantity, // La quantité de tickets disponibles pour le type de ticket.
			'description' => $this->resource->description // La description du type de ticket.
		];
	}
}
