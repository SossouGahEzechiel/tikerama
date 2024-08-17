<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Événements", description="Endpoints relatifs aux événements.")
 */
class EventApiController extends Controller
{
	/**
	 * Affiche une liste paginée des événements à venir.
	 *
	 * Cette méthode récupère une collection d'événements basée sur la date actuelle
	 * et applique un filtrage sur l'attribut 'code' si fourni dans la requête.
	 * Les événements sont paginés et triés par leur date en ordre croissant.
	 *
	 *  * @OA\Get(
	 *     path="/api/events",
	 *     tags={"Événements"},
	 *     summary="Liste des événements à venir",
	 *     description="Récupère une liste d'événements filtrée et paginée.",
	 *     @OA\Parameter(
	 *         name="code",
	 *         in="query",
	 *         required=false,
	 *         description="Filtre les événements par code.",
	 *         @OA\Schema(type="string")
	 *     ),
	 *     @OA\Parameter(
	 *         name="perPage",
	 *         in="query",
	 *         required=false,
	 *         description="Nombre d'événements par page.",
	 *         @OA\Schema(type="integer")
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Liste paginée des événements",
	 *         @OA\JsonContent(ref="#/components/schemas/EventResource")
	 *     ),
	 *     @OA\Response(
	 *         response=400,
	 *         description="Requête incorrecte."
	 *     )
	 * )
	 *
	 * @return AnonymousResourceCollection
	 */
	public function index(): AnonymousResourceCollection
	{
		return EventResource::collection(
			Event::query()
				->when(
					request()->has('code'),
					fn(Builder $builder) => $builder->where('code', 'like', "%" . request()->input('code') . "%")
				)
				->whereYear('date', '>=', ($today = today())->year)
				->whereMonth('date', '>=', $today->month)
				->whereDay('date', '>=', $today->day)
				->orderBy('date')
				->paginate(request()->query->getInt('perPage', 21))
		);
	}

	/**
	 * Affiche un événement unique basé sur son slug.
	 *
	 * Cette méthode récupère un événement en utilisant le slug fourni. Si aucun
	 * événement n'est trouvé, elle renvoie une réponse 404. Si un événement est trouvé,
	 * il est retourné sous forme de ressource avec sa relation 'ticketTypes' chargée.
	 *
	 * @OA\Get(
	 *     path="/api/events/{slug}",
	 *     tags={"Événements"},
	 *     summary="Détails d'un événement",
	 *     description="Récupère un événement en utilisant son slug.",
	 *     @OA\Parameter(
	 *         name="slug",
	 *         in="path",
	 *         required=true,
	 *         description="Le slug de l'événement.",
	 *         @OA\Schema(type="string")
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Détails de l'événement.",
	 *         @OA\JsonContent(ref="#/components/schemas/EventResource")
	 *     ),
	 *     @OA\Response(
	 *         response=404,
	 *         description="Aucun événement trouvé."
	 *     )
	 * )
	 *
	 * @param string $slug Le slug de l'événement.
	 * @return Response|EventResource
	 */
	public function get(string $slug): Response|EventResource
	{
		if (!$event = Event::query()->firstWhere('slug', $slug)) {
			return __404();
		}

		return new EventResource($event->load('ticketTypes'));
	}
}
