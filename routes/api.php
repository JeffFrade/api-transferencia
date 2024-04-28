<?php

use App\Http\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\TransferenceController;

Route::group(['prefix' => 'transfer'], function () {
    Route::post('/', [TransferenceController::class, 'send'])
        ->name('transfer.send');
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/', [UserController::class, 'store'])
        ->name('users.store');
});
