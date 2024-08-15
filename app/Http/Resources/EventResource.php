<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{

	public function toArray(Request $request): array
	{
		return [
			'title' => $this->resource->title,
			'code' => $this->resource->code,
			'date' => $this->resource->date->translatedFormat('D d M Y'), // sam. 07 sept. 2024
			'hour' => $this->resource->date->translatedFormat('H:i'), // 16h00
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
