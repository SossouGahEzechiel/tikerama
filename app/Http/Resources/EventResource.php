<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
			'title' => $this->resource->title,
			'code' => $this->resource->code,
			'date' => $this->resource->date->translatedFormat('D d M Y'),
			'hour' => $this->resource->date->translatedFormat('H:i'),
			'city' => $this->resource->city,
			'slug' => $this->resource->slug,
			'image' => $this->resource->image,
			'description' => $this->resource->description,
			'category' => $this->resource->category->value,
			'types' => TicketTypeResource::collection($this->whenLoaded('ticketTypes')),
			'lowerPrice' => $this->resource->getLowerTicketPrice() !== 0 ? $this->resource->getLowerTicketPrice() : 'Gratuit',
		];
	}
}
