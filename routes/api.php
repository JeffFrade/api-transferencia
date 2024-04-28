<?php

use App\Http\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\TransferenceController;

Route::group(['prefix' => 'transfer'], function () {
    Route::post('/', [TransferenceController::class, 'send'])
        ->name('transfer.send');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index'])
        ->name('user.index');

    Route::post('/', [UserController::class, 'store'])
        ->name('user.store');

    Route::put('/{id}', [UserController::class, 'update'])
        ->name('user.update');

    Route::delete('/{id}', [UserController::class, 'delete'])
        ->name('user.delete');
});
