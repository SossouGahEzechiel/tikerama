<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IntentResource;
use App\Models\Intent;
use App\Models\TicketType;
use Illuminate\Http\{Request, Response};

class IntentApiController extends Controller
{
	public function store(Request $request): Response|IntentResource
	{
		$rules = [
			'email' => ['required', 'email'],
			'phone' => ['required', 'min:10', 'max:20'],
			'content' => ['required', 'array'],
			'eventSlug' => ['required', 'exists:events,slug']
		];

		$attributes = [
			'phone' => 'Votre numéro de téléphone',
			'email' => 'Votre adresse email',
		];

		$messages = [
			'content.json' => 'Oups',
			'content' => $error = 'Les informations que vous avez fournies sont invalides',
			'eventSlug' => $error
		];


		$validator = validator($request->all(), $rules, $messages, $attributes);

		if ($validator->fails()) {
			return __422($validator->errors()->first());
		}

		$typesCollection = $request->collect('content');

		$types = TicketType::query()->whereIn('slug', $typesCollection->pluck('slug')->toArray())->get();

		if ($types->count() != $typesCollection->count()) {
			return __422($error);
		}

		$amount = 0;
		$content = [];
		$unComputed = null;
		foreach ($types as $key => $type) {
			$count = $typesCollection->get($key)['count'];
			if ($count <= $type->quantity) {
				$amount += $type->price * $count;
				$content[] = [
					'typeId' => $type->id,
					'count' => $count
				];
				$type->update([
					'quantity' => $type->quantity - $count
				]);
			} else {
				$unComputed = "Certains tickets ne sont plus disponibles";
			}
		}

		/**
		 * @var Intent $intent
		 */
		$intent = Intent::query()->create([
			'content' => $content,
			'price' => $amount,
			'expiration_date' => now()->addMinutes(30),
			'author_email' => $request->input('email'),
			'author_phone' => $request->input('phone'),
			'event_id' => $types->first()->event_id
		]);

		$intent->setAttribute('unComputed', $unComputed);

		return (new IntentResource($intent->load('event')));
	}

	public function get(string $slug): Response|IntentResource
	{
		if (!$intent = Intent::query()->firstWhere('slug', $slug))
			return __404("L'intention de commande à laquelle vous essayez d'accéder semble ne pas exister");

		return new IntentResource($intent->load('event'));
	}
}
