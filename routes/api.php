<?php

use App\Http\Controllers\Process\CreateProcessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('api/v1/')->name('api.v1.')->group(function () {
    Route::prefix('process')->name('process.')->group(function () {
        Route::post('create', [CreateProcessController::class, 'store'])->name('create');
    });
});
