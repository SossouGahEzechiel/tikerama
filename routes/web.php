<?php

use App\Http\Controllers\ApiAccessRequestController;
use Illuminate\Support\Facades\Route;

Route::get('', fn() => to_route('api-access.create'));

Route::controller(ApiAccessRequestController::class)->prefix('demandes')->name('api-access.')->group(function () {
	Route::get('', 'create')->name('create');
	Route::post('', 'store')->name('store');
});