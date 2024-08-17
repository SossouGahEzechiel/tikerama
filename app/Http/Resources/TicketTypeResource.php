<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TicketTypeResource",
 *     type="object",
 *     title="Ticket Type Resource",
 *     description="Représentation d'un type de ticket.",
 *     required={"name", "slug", "price", "quantity", "description"},
 *     @OA\Property(property="name", type="string", example="VIP"),
 *     @OA\Property(property="slug", type="string", example="vip-ticket"),
 *     @OA\Property(property="price", type="number", example=15000),
 *     @OA\Property(property="quantity", type="integer", example=100),
 *     @OA\Property(property="description", type="string", example="Accès VIP avec des sièges réservés.")
 * )
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
