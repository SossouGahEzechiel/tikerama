<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ressource pour représenter un événement dans l'API.
 */
class EventResource extends JsonResource
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
			'title' => $this->resource->title, // Le titre de l'événement.
			'code' => $this->resource->code, // Le code unique de l'événement.
			// La date de l'événement au format "Jour NuméroDuJour Mois Année". Exemple : sam. 07 sept. 2024
			'date' => $this->resource->date->translatedFormat('D d M Y'),
			'hour' => $this->resource->date->translatedFormat('H:i'), // L'heure de l'événement au format "Heure : Minute". Exemple : 16:00
			'city' => $this->resource->city, // La ville où se déroule l'événement.
			'slug' => $this->resource->slug, // Le slug unique de l'événement.
			'image' => $this->resource->image, // L'URL de l'image de l'événement.
			'description' => $this->resource->description, // La description de l'événement.
			'category' => $this->resource->category->value, // La catégorie de l'événement.
			'types' => TicketTypeResource::collection($this->whenLoaded('ticketTypes')), // Les types de tickets associés à l'événement.
			// Le prix le plus bas parmi tous les types de tickets associés à l'événement, ou "Gratuit" s'il n'y a pas de type de ticket payant.
			'lowerPrice' => $this->resource->getLowerTicketPrice() !== 0 ? $this->resource->getLowerTicketPrice() : 'Gratuit',
		];
	}
}
