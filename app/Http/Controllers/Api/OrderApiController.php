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
	 * Crée une nouvelle commande en fonction d'une intention de commande existante.
	 *
	 * Cette méthode valide le moyen de paiement envoyé dans la requête, récupère l'intention de commande
	 * associée au slug fourni, puis crée une nouvelle commande. Elle génère également les tickets associés
	 * en utilisant les informations présentes dans l'intention de commande.
	 *
	 * @param Request $request La requête contenant les données de la commande, y compris le moyen de paiement.
	 * @param string $slug Le slug de l'intention de commande.
	 * @return Response|OrderResource La réponse contenant les détails de la commande créée ou une réponse d'erreur en cas d'échec.
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
			// Création de la commande avec les informations de l'intention
			$order = Order::query()->create([
				'price' => $intent->getAttribute('price'),
				'author_email' => $intent->getAttribute('author_email'),
				'author_phone' => $intent->getAttribute('author_phone'),
				'event_id' => $intent->getAttribute('event_id'),
				'payment_method' => $request->input('paymentMethod'),
				'number' => Str::upper(Str::random(6)) // Génère un numéro de commande aléatoire
			]);

			// Création des tickets associés à la commande
			$tickets = [];
			foreach (TicketTypeMapper::parse($intent->getAttribute('content')) as $item) {
				$tickets[] = [
					'email' => $intent->getAttribute('author_email'),
					'phone' => $intent->getAttribute('author_phone'),
					'price' => $intent->getAttribute('price'),
					'status' => TicketStatusEnum::VALIDATED, // Définit le statut du ticket à 'VALIDATED'
					'ticket_type_id' => $item->type->id,
					'event_id' => $intent->getAttribute('event_id'),
					'key' => Str::upper(Str::random(6)) // Génère une clé unique pour chaque ticket
				];
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
