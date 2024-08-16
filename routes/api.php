<?php

use App\Http\Controllers\Api\{EventApiController, IntentApiController, OrderApiController, UserApiController};
use App\Http\Middleware\EnsureRequestHasApikeyHeader;
use Illuminate\Support\Facades\Route;

// Groupe de routes protégé par le middleware EnsureRequestHasApikeyHeader
Route::middleware(EnsureRequestHasApikeyHeader::class)->group(function () {

	// Fonction définissant les routes pour l'API
	$routes = function () {
		// Routes pour les événements
		Route::controller(EventApiController::class)->prefix('events')->group(function () {
			Route::get('', 'index'); // Récupérer la liste des événements
			Route::get('{event}', 'get'); // Récupérer un événement spécifique
		});

		// Routes pour les intentions (intents)
		Route::controller(IntentApiController::class)->prefix('intents')->group(function () {
			Route::post('', 'store'); // Créer une nouvelle intention
			Route::get('{intent}', 'get'); // Récupérer une intention spécifique
		});

		// Routes pour les commandes
		Route::controller(OrderApiController::class)->prefix('orders')->group(function () {
			Route::post('{intent}', 'store'); // Créer une nouvelle commande liée à une intention
		});

		// Routes pour les utilisateurs
		Route::controller(UserApiController::class)->prefix('users')->group(function () {
			Route::post('login', 'login'); // Authentification de l'utilisateur
			Route::post('register', 'register'); // Enregistrement d'un nouvel utilisateur
		});
	};

	// Groupe de routes de base
	Route::group([], $routes);

	// Groupe de routes sécurisé nécessitant une authentification avec Sanctum
	Route::middleware('auth:sanctum')->prefix('secure')->group($routes);

	// Route sécurisée pour faire toutes les opérations avec les données de l'utilisateur connecté
	Route::middleware('auth:sanctum')->prefix('secure')->group(function () {
		Route::get('users/my-orders', [UserApiController::class, 'myOrders']); // Récupérer les commandes de l'utilisateur
	});
});
