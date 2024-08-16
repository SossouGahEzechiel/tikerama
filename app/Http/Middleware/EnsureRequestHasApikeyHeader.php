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
			if (!$request->hasHeader('Api-Key-Name') or !$request->hasHeader('Api-Key')) {
				return $errorResponse;
			}

			if (!($user = ApiAccessRequest::query()->firstWhere('slug', $request->header('Api-Key-Name')))) {
				return $errorResponse;
			}

			if (!Hash::check($user->api_key, $request->header('Api-Key'))) {
				return $errorResponse;
			}
		} catch (Throwable) {
			return $errorResponse;
		}

		return $next($request);
	}
}
