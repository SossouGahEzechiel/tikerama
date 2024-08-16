<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IntentResource;
use App\Models\{Intent, TicketType};
use Illuminate\Http\{Request, Response};

/**
 * Contrôleur pour les actions liées aux intentions de commande dans l'API.
 */
class IntentApiController extends Controller
{
	/**
	 * Stocke une nouvelle intention de commande dans la base de données.
	 *
	 * @param Request $request La requête HTTP entrante.
	 * @return Response|IntentResource La réponse HTTP ou la ressource Intent.
	 */
	public function store(Request $request): Response|IntentResource
	{
		$subRules = [
			'email' => ['nullable'],
			'phone' => ['nullable']
		];

		if (!request()->user()) {
			$subRules = [
				'email' => ['required', 'email'],
				'phone' => ['required', 'min:10', 'max:20']
			];
		}

		$rules = [
			...$subRules,
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
		if ($amount === 0) {
			return __200($unComputed);
		}

		$user = $request->user();

		/**
		 * Crée une nouvelle instance de l'intention de commande.
		 *
		 * @var Intent $intent
		 */
		$intent = Intent::query()->create([
			'content' => $content,
			'price' => $amount,
			'expiration_date' => now()->addMinutes(30),
			'author_email' => $user?->email ?? $request->input('email'),
			'author_phone' => $user?->phone ?? $request->input('phone'),
			'event_id' => $types->first()->event_id,
			'user_id' => $user?->id
		]);

		$intent->setAttribute('unComputed', $unComputed);

		return (new IntentResource($intent->load('event')));
	}

	/**
	 * Récupère une intention de commande à partir de son slug.
	 *
	 * @param string $slug Le slug de l'intention de commande.
	 * @return Response|IntentResource La réponse HTTP ou la ressource Intent.
	 */
	public function get(string $slug): Response|IntentResource
	{
		if (!$intent = Intent::query()->firstWhere('slug', $slug))
			return __404("L'intention de commande à laquelle vous essayez d'accéder semble ne pas exister");

		return new IntentResource($intent->load('event'));
	}
}
