<?php

use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\IntentApiController;
use Illuminate\Support\Facades\Route;

Route::controller(EventApiController::class)->prefix('events')->group(function () {
	Route::get('', 'index');
	Route::get('{event}', 'get');
});

Route::controller(IntentApiController::class)->prefix('intents')->group(function () {
	Route::post('', 'store');
	Route::get('{intent}', 'get');
	Route::patch('{intent}', 'update');
});