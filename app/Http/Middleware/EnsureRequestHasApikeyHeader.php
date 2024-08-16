<?php

namespace App\Http\Middleware;

use App\Models\ApiAccessRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EnsureRequestHasApikeyHeader
{

	private const API_KEY_NAME = 'Api-Key-Name'; // Nom de l'en-tête pour l'identifiant de l'API

	private const API_KEY = 'Api-Key'; // Nom de l'en-tête pour la clé API

	/**
	 * Gère une requête entrante et vérifie les en-têtes d'API.
	 *
	 * Ce middleware vérifie que la requête contient des en-têtes spécifiques
	 * correspondant à un identifiant d'API et une clé API. Si ces en-têtes
	 * sont présents et valides, la requête est autorisée à continuer.
	 *
	 * @param Request $request La requête HTTP entrante
	 * @param Closure(Request): (Response) $next La fonction de continuation de la requête
	 * @return Response La réponse HTTP (soit l'autorisation de continuer, soit un refus)
	 */
	public function handle(Request $request, Closure $next): Response
	{
		// Réponse d'erreur standard à retourner en cas d'échec de validation
		$errorResponse = response(["Vous n'êtes pas autorisé à accéder à cette ressource. Vérifiez vos identifiants de connexion."], 403);

		try {
			// Vérifie si les en-têtes API_KEY_NAME et API_KEY sont présents dans la requête
			if (!$request->hasHeader(static::API_KEY_NAME) or !$request->hasHeader(self::API_KEY)) {
				return $errorResponse;
			}

			// Récupère la requête d'accès à l'API basée sur le slug présent dans l'en-tête API_KEY_NAME
			if (!($apiAccessRequest = ApiAccessRequest::query()->firstWhere('slug', $request->header(self::API_KEY_NAME)))) {
				return $errorResponse;
			}

			// Vérifie que la clé API dans l'en-tête correspond bien à celle stockée dans la base de données
			if (!Hash::check($apiAccessRequest->api_key, $request->header(self::API_KEY))) {
				return $errorResponse;
			}
		} catch (Throwable) {
			// En cas d'exception ou d'erreur, renvoie la réponse d'erreur
			return $errorResponse;
		}

		// Si toutes les validations sont réussies, la requête peut continuer
		return $next($request);
	}
}
