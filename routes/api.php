<?php

use App\Http\Controllers\Process\CreateProcessController;
use App\Http\Controllers\Process\UpdateProcessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1/')->name('api.v1.')->group(function () {
    Route::prefix('process')->name('process.')->group(function () {
        Route::post('create', [CreateProcessController::class, 'store'])->name('create');
        Route::put('update/{uuid}', [UpdateProcessController::class, 'update'])->name('update');
    });
});
