<?php

namespace App\Http\Controllers\Api;

use App\Enums\TicketStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\IntentResource;
use App\Mappers\TicketTypeMapper;
use App\Models\Intent;
use App\Models\Order;
use App\Models\TicketType;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Str;
use Throwable;

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
				$unComputed = "Certains tickets sont soit insuffisant pour satisfaire votre demande ou ne sont plus disponibles";
			}
		}
		if ($amount === 0)
			return __200($unComputed);

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

	public function update(Request $request, string $slug): Response|Order
	{
		$validator = validator($request->only('paymentMethod'), [
			'paymentMethod' => 'required'
		], attributes: [
			'paymentMethod' => 'Le moyen de payement'
		]);

		if ($validator->fails()) {
			return __422($validator->errors()->first());
		}

		/**
		 * @var Intent $intent
		 * @var Order $order
		 */
		if (!$intent = Intent::query()->firstWhere('slug', $slug))
			return __404("L'intention de commande à laquelle vous essayez d'accéder semble ne pas exister");

		try {
			$order = Order::query()->create([
				'price' => $intent->getAttribute('price'),
				'author_email' => $intent->getAttribute('author_email'),
				'author_phone' => $intent->getAttribute('author_phone'),
				'event_id' => $intent->getAttribute('event_id'),
				'payment_method' => $request->input('paymentMethod'),
				'number' => Str::upper(Str::random(6))
			]);

			$tickets = [];
			foreach (TicketTypeMapper::parse($intent->getAttribute('content')) as $item) {
				$tickets[] = [
					'email' => $intent->getAttribute('author_email'),
					'phone' => $intent->getAttribute('author_phone'),
					'price' => $intent->getAttribute('price'),
					'status' => TicketStatusEnum::VALIDATED,
					'ticket_type_id' => $item->type->id,
					'event_id' => $intent->getAttribute('event_id'),
					'key' => Str::upper(Str::random(6))
				];
			}

			$order->tickets()->createMany($tickets);

			$intent->delete();
		} catch (Throwable $throwable) {
			return __500($throwable->getMessage());
		}

		return $order->load('tickets');
	}
}
