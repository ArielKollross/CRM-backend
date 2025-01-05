<?php

use App\Http\Controllers\Card\CreateCardController;
use App\Http\Controllers\Card\ListCardsController;
use App\Http\Controllers\Process\CreateProcessController;
use App\Http\Controllers\Process\ListProcessesController;
use App\Http\Controllers\Process\UpdateProcessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1/')->name('api.v1.')->group(function () {
    Route::prefix('process')->name('process.')->group(function () {
        Route::post('create', [CreateProcessController::class, 'store'])->name('create');
        Route::put('update/{uuid}', [UpdateProcessController::class, 'update'])->name(name: 'update');
        Route::get('list', [ListProcessesController::class, 'index'])->name('list');
    });

    Route::prefix('card')->name('card.')->group(function () {
        Route::post('create', [CreateCardController::class, 'store'])->name('create');
        Route::get('list', [ListCardsController::class, 'index'])->name('list');
    });
});
