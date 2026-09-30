<?php

require_once __DIR__ . '/../Controllers/CheckoutController.php';

use Illuminate\Support\Facades\Route;
use Plugin\Sepay\Controllers\CheckoutController;

Route::prefix('api/v1/guest/sepay')->name('sepay.')->group(function () {
    Route::get('/check/{tradeNo}', [CheckoutController::class, 'check'])->name('check');
});