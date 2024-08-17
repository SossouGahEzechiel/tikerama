<?php

namespace App\Http\Controllers\Api;

use App\Enums\TicketStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Mappers\TicketTypeMapper;
use App\Models\Intent;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;
use Throwable;

/**
 * Contrôleur API responsable de la gestion des commandes.
 *
 * Cette classe fournit des fonctionnalités pour créer des commandes en fonction des intentions
 * préalablement créées et gérer les tickets associés aux commandes.
 *
 * @package Tikerama-Test
 * @author SOSSOU-GAH Ézéchiel
 */
class OrderApiController extends Controller
{
	/**
	 * @OA\Post(
	 *     path="/api/orders/{slug}",
	 *     summary="Créer une nouvelle commande à partir d'une intention",
	 *     description="Cette route permet de créer une nouvelle commande en utilisant les informations d'une intention de commande existante. Elle génère également les tickets associés.",
	 *     operationId="createOrder",
	 *     tags={"Orders"},
	 *     @OA\Parameter(
	 *         name="slug",
	 *         in="path",
	 *         required=true,
	 *         description="Le slug de l'intention de commande.",
	 *         @OA\Schema(type="string", example="intent-slug-123")
	 *     ),
	 *     @OA\RequestBody(
	 *         required=true,
	 *         description="Données de la commande incluant le moyen de paiement",
	 *         @OA\JsonContent(
	 *             required={"paymentMethod"},
	 *             @OA\Property(property="paymentMethod", type="string", example="Credit Card")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Commande créée avec succès.",
	 *         @OA\JsonContent(ref="#/components/schemas/OrderResource")
	 *     ),
	 *     @OA\Response(
	 *         response=404,
	 *         description="L'intention de commande n'existe pas.",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="L'intention de commande à laquelle vous essayez d'accéder semble ne pas exister")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=422,
	 *         description="Erreur de validation des données fournies.",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Le moyen de payement est requis.")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=500,
	 *         description="Erreur serveur lors de la création de la commande.",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Une erreur est survenue lors du traitement de la commande.")
	 *         )
	 *     )
	 * )
	 */
	public function store(Request $request, string $slug): Response|OrderResource
	{
		// Valide le champ 'paymentMethod' dans la requête
		$validator = validator($request->only('paymentMethod'), [
			'paymentMethod' => 'required'
		], attributes: [
			'paymentMethod' => 'Le moyen de payement'
		]);

		// Si la validation échoue, retourne une réponse 422 avec le premier message d'erreur
		if ($validator->fails()) {
			return __422($validator->errors()->first());
		}

		/**
		 * @var Intent $intent L'intention de commande récupérée par le slug
		 * @var Order $order La commande créée à partir de l'intention
		 */
		if (!$intent = Intent::query()->firstWhere('slug', $slug))
			return __404("L'intention de commande à laquelle vous essayez d'accéder semble ne pas exister");

		try {

			$user = $request->user();

			// Création de la commande avec les informations de l'intention
			$order = Order::query()->create([
				'price' => $intent->getAttribute('price'),
				'author_email' => $user?->email ?? $intent->getAttribute('author_email'),
				'author_phone' => $user?->phone ?? $intent->getAttribute('author_phone'),
				'event_id' => $intent->getAttribute('event_id'),
				'payment_method' => $request->input('paymentMethod'),
				'number' => Str::upper(Str::random(6)), // Génère un numéro de commande aléatoire,
				'user_id' => $user?->id // L'id de l'utilisateur s'il est connecté
			]);

			// Création des tickets associés à la commande
			$tickets = [];
			foreach (TicketTypeMapper::parse($intent->getAttribute('content')) as $item) {
				// On crée autant de ticket que l'utilisateur l'a demandé
				for ($i = 0; $i < $item->count; $i++) {
					$tickets[] = [
						'email' => $user?->email ?? $intent->getAttribute('author_email'),
						'phone' => $user?->phone ?? $intent->getAttribute('author_phone'),
						'price' => $item->type->price,
						'status' => TicketStatusEnum::VALIDATED, // Définit le statut du ticket à 'VALIDATED'
						'ticket_type_id' => $item->type->id,
						'event_id' => $intent->getAttribute('event_id'),
						'key' => Str::upper(Str::random(6)) // Génère une clé unique pour chaque ticket
					];
				}
			}

			// Ajoute les tickets à la commande
			$order->tickets()->createMany($tickets);

			// Supprime l'intention de commande une fois traitée
			$intent->delete();
		} catch (Throwable $throwable) {
			// Retourne une réponse 500 en cas d'exception
			return __500($throwable->getMessage());
		}

		// Retourne la commande créée avec les tickets associés
		return new OrderResource($order->load('tickets'));
	}
}
