<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Classe de ressource pour transformer les données de la commande en format JSON.
 *
 * Cette ressource est utilisée pour formater les données d'une instance de la classe Order
 * lorsqu'elle est retournée en réponse à une requête API.
 *
 * @package Tikerama-Test
 * @author SOSSOU-GAH Ézéchiel
 */
class OrderResource extends JsonResource
{
	/**
	 * Transforme la ressource en tableau.
	 *
	 * Cette méthode définit la structure de la réponse JSON renvoyée par l'API
	 * lorsque des informations sur une commande sont demandées. Elle inclut les détails
	 * de la commande ainsi que les informations associées à l'événement et aux tickets.
	 *
	 * @param Request $request La requête HTTP en cours de traitement.
	 * @return array Un tableau associatif représentant les données de la commande.
	 */
	public function toArray(Request $request): array
	{
		return [
			'slug' => $this->resource->slug, // Le slug unique de la commande
			'price' => $this->resource->price, // Le prix total de la commande
			'authorEmail' => $this->resource->author_email, // L'email de l'auteur de la commande
			'authorPhone' => $this->resource->author_phone, // Le numéro de téléphone de l'auteur de la commande
			'event' => new EventResource($this->whenLoaded('event')), // Les détails de l'événement associé, si chargé
			'paymentMethod' => $this->resource->payment_method, // Le moyen de paiement utilisé pour la commande
			'number' => $this->resource->number, // Le numéro de la commande
			'createdAt' => $this->resource->created_at->translatedFormat('d F Y H:i'), // La date et l'heure de création de la commande, formatée
			'tickets' => TicketResource::collection($this->whenLoaded('tickets')), // Les tickets associés à la commande, si chargés
		];
	}
}
