<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'transfer'], function () {
    Route::post('/', [\App\Http\TransferenceController::class, 'send'])
        ->name('transfer.send');
})->withoutMiddleware('*');
