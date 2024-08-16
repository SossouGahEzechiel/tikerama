<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\{OrderResource, UserResource};
use App\Models\User;
use Illuminate\Http\{Request, Response};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserApiController extends Controller
{
	/**
	 * Enregistre un nouvel utilisateur.
	 *
	 * @param Request $request
	 * @return Response|UserResource
	 * Retourne une réponse en cas d'erreur ou les données de l'utilisateur enregistré.
	 */
	public function register(Request $request): Response|UserResource
	{
		// Définition des attributs et messages de validation personnalisés
		$attributes = [
			'email' => 'Votre adresse email',
			'password' => 'Votre mot de passe',
			'firstName' => 'Votre prénom',
			'lastName' => 'Votre nom',
			'phone' => 'Votre numéro de téléphone',
		];

		$messages = [
			'email.unique' => 'Cette adresse email est déjà prise'
		];

		// Validation des données envoyées par l'utilisateur
		$validator = validator($request->all(), [
			'lastName' => ['required'],  // Le nom est requis
			'firstName' => ['required'], // Le prénom est requis
			'phone' => ['required'],     // Le numéro de téléphone est requis
			'email' => ['nullable', 'email', 'unique:users'], // L'email doit être unique
			'password' => ['required', 'confirmed'], // Le mot de passe doit être confirmé
		], $messages, $attributes);

		// Si la validation échoue, retour d'une réponse avec un statut 422
		if ($validator->fails()) {
			return __422($validator->errors()->first());
		}

		try {
			// Création d'un nouvel utilisateur dans la base de données
			$user = User::query()->create([
				'firstname' => $request->input('firstName'),
				'lastname' => $request->input('lastName'),
				'phone' => $request->input('phone'),
				'email' => $request->input('email'),
				'password' => Hash::make($request->input('password')), // Hashage du mot de passe
			]);

			// Génération d'un token d'authentification pour l'utilisateur
			$user->setAttribute('token', $user->createToken('auth-token')->plainTextToken);

		} catch (Throwable $exception) {
			// Gestion des erreurs lors de la création de l'utilisateur
			return __500($exception->getMessage());
		}

		// Retourne les informations de l'utilisateur nouvellement créé
		return new UserResource($user);
	}

	/**
	 * Authentifie un utilisateur et génère un token d'accès.
	 *
	 * @param Request $request
	 * @return Response|UserResource
	 * Retourne une réponse d'erreur ou les informations de l'utilisateur avec un token d'accès.
	 */
	public function login(Request $request): Response|UserResource
	{
		// Validation des informations d'authentification
		$validator = validator($request->all(), [
			'email' => ['required', 'email'],    // L'adresse email est requise
			'password' => ['required']           // Le mot de passe est requis
		]);

		// Si la validation échoue, retour d'une réponse avec un statut 401 (non autorisé)
		if ($validator->fails()) {
			return response(trans('auth.failed'), 401);
		}

		try {
			// Recherche de l'utilisateur en fonction de l'adresse email
			$user = User::query()->firstWhere('email', $request->input('email'));

			// Vérification du mot de passe de l'utilisateur
			if (!$user or !Hash::check($request->input('password'), $user->getAttribute('password'))) {
				return response(trans('auth.failed'), 401); // Retourne une erreur si l'authentification échoue
			}

			// Génération d'un token d'accès pour l'utilisateur authentifié
			$user->setAttribute('token', $user->createToken('auth-token')->plainTextToken);

		} catch (Throwable $exception) {
			// Gestion des erreurs lors de l'authentification
			return __500($exception->getMessage());
		}

		// Retourne les informations de l'utilisateur avec les relations 'department' et 'church'
		return new UserResource($user->load('department', 'church'));
	}

	/**
	 * Récupère les commandes de l'utilisateur connecté.
	 *
	 * @return AnonymousResourceCollection
	 * Retourne une collection des commandes paginées de l'utilisateur.
	 */
	public function myOrders(): AnonymousResourceCollection
	{
		// Retourne les commandes paginées de l'utilisateur connecté
		return OrderResource::collection(request()
			->user()
			->orders()
			->with('tickets')
			->paginate(request()->query->getInt('perPage', 15))
		);
	}
}
