<?php

use App\Http\Controllers\Api\{EventApiController, IntentApiController, OrderApiController, UserApiController};
use App\Http\Middleware\EnsureRequestHasApikeyHeader;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureRequestHasApikeyHeader::class)->group(function () {

	$routes = function () {
		Route::controller(EventApiController::class)->prefix('events')->group(function () {
			Route::get('', 'index');
			Route::get('{event}', 'get');
		});

		Route::controller(IntentApiController::class)->prefix('intents')->group(function () {
			Route::post('', 'store');
			Route::get('{intent}', 'get');
		});

		Route::controller(OrderApiController::class)->prefix('orders')->group(function () {
			Route::post('{intent}', 'store');
		});

		Route::controller(UserApiController::class)->prefix('users')->group(function () {
			Route::post('login', 'login');
			Route::post('register', 'register');
		});
	};

	Route::group([], $routes);

	Route::middleware('auth:sanctum')->prefix('secure')->group($routes);

	Route::middleware('auth:sanctum')->prefix('secure')->group(function () {
		Route::get('users/my-orders', [UserApiController::class, 'myOrders']);
	});
});
