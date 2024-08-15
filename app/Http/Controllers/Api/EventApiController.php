<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventApiController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		return EventResource::collection(Event::query()
			->with(['ticketTypes' => fn($builder) => $builder->orderByDesc('price')])
			->paginate(request()->query->get('perPage', 21))
		);
	}

	public function show(Event $event)
	{
		return $event;
	}
}
