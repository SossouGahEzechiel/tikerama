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

	private const API_KEY_NAME = 'Api-Key-Name';

	private const API_KEY = 'Api-Key';

	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure(Request): (Response) $next
	 * @return Response
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$errorResponse = response(["Vous n'êtes pas autorisé à accéder à cette ressource. Vérifiez vos identifiants de connexion."], 403);

		try {
			if (!$request->hasHeader(static::API_KEY_NAME) or !$request->hasHeader(self::API_KEY)) {
				return $errorResponse;
			}

			if (!($apiAccessRequest = ApiAccessRequest::query()->firstWhere('slug', $request->header(self::API_KEY_NAME)))) {
				return $errorResponse;
			}

			if (!Hash::check($apiAccessRequest->api_key, $request->header(self::API_KEY))) {
				return $errorResponse;
			}
		} catch (Throwable) {
			return $errorResponse;
		}

		return $next($request);
	}
}
