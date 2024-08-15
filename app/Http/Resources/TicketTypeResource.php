<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketTypeResource extends JsonResource
{

	public function toArray(Request $request): array
	{
		return [
			'name' => $this->resource->name,
			'slug' => $this->resource->slug,
			'price' => $this->resource->price,
			'quantity' => $this->resource->quantity,
			'description' => $this->resource->description
		];
	}
}
