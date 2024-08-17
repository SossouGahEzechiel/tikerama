<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;
use App\Http\Resources\{OrderResource, UserResource};
use App\Models\User;
use Illuminate\Http\{Request, Response};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserApiController extends Controller
{
	/**
	 * @OA\Post(
	 *     path="/api/register",
	 *     summary="Enregistre un nouvel utilisateur",
	 *     tags={"User"},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             required={"firstName", "lastName", "phone", "password", "password_confirmation"},
	 *             @OA\Property(property="firstName", type="string", example="John"),
	 *             @OA\Property(property="lastName", type="string", example="Doe"),
	 *             @OA\Property(property="phone", type="string", example="123456789"),
	 *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
	 *             @OA\Property(property="password", type="string", format="password", example="password"),
	 *             @OA\Property(property="password_confirmation", type="string", format="password", example="password"),
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=201,
	 *         description="Utilisateur enregistré avec succès",
	 *         @OA\JsonContent(ref="#/components/schemas/UserResource")
	 *     ),
	 *     @OA\Response(
	 *         response=422,
	 *         description="Erreur de validation"
	 *     )
	 * )
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
	 * @OA\Post(
	 *     path="/api/login",
	 *     summary="Authentifie un utilisateur et génère un token d'accès",
	 *     tags={"Utilisateur"},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         description="Les informations d'authentification",
	 *         @OA\JsonContent(
	 *             required={"email", "password"},
	 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
	 *             @OA\Property(property="password", type="string", format="password", example="password123"),
	 *         ),
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Authentification réussie, renvoie les informations de l'utilisateur et un token",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="firstName", type="string", example="John"),
	 *             @OA\Property(property="lastName", type="string", example="Doe"),
	 *             @OA\Property(property="email", type="string", example="user@example.com"),
	 *             @OA\Property(property="phone", type="string", example="+1234567890"),
	 *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=401,
	 *         description="Erreur d'authentification, identifiants incorrects",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Ces identifiants ne correspondent pas à nos enregistrements.")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=422,
	 *         description="Erreur de validation des données",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="L'adresse email est requise.")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=500,
	 *         description="Erreur serveur",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Une erreur est survenue lors de l'authentification.")
	 *         )
	 *     )
	 * )
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
