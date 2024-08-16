<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'firstName' => $this->resource->firstname,
			'lastName' => $this->resource->lastname,
			'email' => $this->resource->email,
			'phone' => $this->resource->phone,
			'token' => $this->whenHas('token', $this->resource->token),
			'orders' => $this->whenLoaded('orders', $this->resource->orders)
		];
	}
}
