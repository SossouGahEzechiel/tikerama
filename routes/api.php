<?php

use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\IntentApiController;
use App\Http\Controllers\Api\OrderApiController;
use Illuminate\Support\Facades\Route;

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