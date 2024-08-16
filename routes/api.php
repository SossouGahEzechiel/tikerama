<?php

use App\Http\Controllers\Api\{EventApiController, IntentApiController, OrderApiController};
use App\Http\Middleware\EnsureRequestHasApikeyHeader;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureRequestHasApikeyHeader::class)->group(function () {

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
});
