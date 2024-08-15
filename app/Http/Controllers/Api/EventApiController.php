<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EventApiController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		return EventResource::collection(Event::query()
			->when(request()->has('code'), fn(Builder $builder) => $builder->where('code', 'like', "%" . request()->input('code') . "%"))
			->paginate(request()->query->get('perPage', 21))
		);
	}

	public function show(string $slug): Response|EventResource
	{
		/**
		 * @var Event $event
		 */
		if (!$event = Event::query()->firstWhere('slug', $slug)) {
			return __404();
		}

		return new EventResource($event->load('ticketTypes'));
	}
}
