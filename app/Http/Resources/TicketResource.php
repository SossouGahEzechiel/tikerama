<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Classe de ressource pour transformer les données d'un ticket en format JSON.
 *
 * Cette ressource est utilisée pour formater les données d'une instance de la classe Ticket
 * lorsqu'elle est retournée en réponse à une requête API.
 *
 * @package Tikerama-Test
 * @author SOSSOU-GAH Ézéchiel
 */
class TicketResource extends JsonResource
{
	/**
	 * Transforme la ressource en tableau.
	 *
	 * Cette méthode définit la structure de la réponse JSON renvoyée par l'API
	 * lorsque des informations sur un ticket sont demandées. Elle inclut les détails
	 * du ticket, ainsi que les relations avec l'événement et la commande associés.
	 *
	 * @param Request $request La requête HTTP en cours de traitement.
	 * @return array Un tableau associatif représentant les données du ticket.
	 */
	public function toArray(Request $request): array
	{
		return [
			'key' => $this->resource->key, // La clé unique du ticket
			'price' => $this->resource->price, // Le prix du ticket
			'status' => $this->resource->status->value, // Le statut du ticket (ex. VALIDATED, CANCELLED)
			'createdAt' => $this->resource->created_at->translatedFormat('d F Y H:i'), // La date et l'heure de création du ticket, formatée
			'event' => new EventResource($this->whenLoaded('event')), // Les détails de l'événement associé, si chargé
			'order' => new OrderResource($this->whenLoaded('order')), // Les détails de la commande associée, si chargé
			'email' => $this->resource->email, // L'email associé au ticket
			'phone' => $this->resource->phone, // Le numéro de téléphone associé au ticket
		];
	}
}
