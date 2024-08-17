<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IntentResource;
use App\Models\{Intent, TicketType};
use Illuminate\Http\{Request, Response};
use OpenApi\Annotations as OA;

/**
 * Contrôleur pour les actions liées aux intentions de commande dans l'API.
 */
class IntentApiController extends Controller
{
	/**
	 *     /**
	 * @OA\Post(
	 *     path="/api/intents",
	 *     summary="Créer une nouvelle intention de commande",
	 *     tags={"Intentions"},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             @OA\Property(property="email", type="string", format="email", example="example@test.com", nullable=true),
	 *             @OA\Property(property="phone", type="string", example="22890000000", nullable=true),
	 *             @OA\Property(property="content", type="array",
	 *                 @OA\Items(
	 *                     @OA\Property(property="slug", type="string", example="vip-ticket"),
	 *                     @OA\Property(property="count", type="integer", example=2)
	 *                 )
	 *             ),
	 *             @OA\Property(property="eventSlug", type="string", example="concert-du-20-aout")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=201,
	 *         description="Intention de commande créée avec succès",
	 *         @OA\JsonContent(ref="#/components/schemas/IntentResource")
	 *     ),
	 *     @OA\Response(
	 *         response=422,
	 *         description="Les données fournies sont incorrectes"
	 *     )
	 * )
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
	 *      * @OA\Get(
	 *     path="/api/intents/{slug}",
	 *     summary="Récupérer une intention de commande par son slug",
	 *     tags={"Intentions"},
	 *     @OA\Parameter(
	 *         name="slug",
	 *         in="path",
	 *         required=true,
	 *         description="Le slug de l'intention de commande",
	 *         @OA\Schema(type="string")
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Détails de l'intention de commande",
	 *         @OA\JsonContent(ref="#/components/schemas/IntentResource")
	 *     ),
	 *     @OA\Response(
	 *         response=404,
	 *         description="L'intention de commande n'a pas été trouvée"
	 *     )
	 * )
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
