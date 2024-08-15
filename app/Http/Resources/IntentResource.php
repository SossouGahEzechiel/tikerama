<?php

namespace App\Http\Resources;

use App\Mappers\TicketTypeMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntentResource extends JsonResource
{

	public function toArray(Request $request): array
	{
		return [
			'slug' => $this->resource->slug,
			'price' => $this->resource->price,
			'userEmail' => $this->resource->author_email,
			'userPhone' => $this->resource->author_phone,
			'expires_at' => $this->resource->expiration_date->translatedFormat('d F Y H:i:s'),
			'content' => TicketTypeMapper::parse($this->resource->content),
			'event' => new EventResource($this->whenLoaded('event')),
			'payementMethod' => $this->resource->payment_method,
			'unComputed' => $this->whenHas('unComputed', $this->resource->unComputed)
		];
	}
}
