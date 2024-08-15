<?php

use App\Http\Controllers\Api\EventApiController;
use Illuminate\Support\Facades\Route;

Route::controller(EventApiController::class)->prefix('events')->group(function () {
	Route::get('{perPage?}', 'index');
	Route::get('{event}', 'show');
});
