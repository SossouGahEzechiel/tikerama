<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Contrôleur API responsable de la gestion des endpoints liés aux événements.
 * Fournit des fonctionnalités pour lister et afficher les événements avec des
 * options de filtrage basées sur les paramètres de la requête.
 *
 * @package Tikerama-Test
 * @author SOSSOU-GAH Ézéchiel
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
	 * @return AnonymousResourceCollection
	 */
	public function index(): AnonymousResourceCollection
	{
		return EventResource::collection(
			Event::query()
				// Applique un filtre sur 'code' si le paramètre de requête 'code' est présent
				->when(
					request()->has('code'),
					fn(Builder $builder) => $builder->where('code', 'like', "%" . request()->input('code') . "%")
				)
				// Filtre les événements qui sont à la date du jour ou plus tard
				->whereYear('date', '>=', ($today = today())->year)
				->whereMonth('date', '>=', $today->month)
				->whereDay('date', '>=', $today->day)
				// Trie les événements par date en ordre croissant
				->orderBy('date')
				// Pagine les résultats, avec 21 événements par page par défaut
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
	 * @param string $slug Le slug de l'événement.
	 * @return Response|EventResource
	 */
	public function show(string $slug): Response|EventResource
	{
		/**
		 * @var Event $event
		 */
		if (!$event = Event::query()->firstWhere('slug', $slug)) {
			// Retourne une réponse 404 si l'événement n'est pas trouvé
			return __404();
		}

		// Retourne la ressource de l'événement avec la relation ticketTypes chargée
		return new EventResource($event->load('ticketTypes'));
	}
}
