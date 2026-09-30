<?php

require_once __DIR__ . '/../Controllers/CheckoutController.php';

use Illuminate\Support\Facades\Route;
use Plugin\Sepay\Controllers\CheckoutController;

Route::prefix('sepay')->name('sepay.')->group(function () {
    Route::get('/checkout/{tradeNo}', [CheckoutController::class, 'checkout'])->name('checkout');
});