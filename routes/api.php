<?php

use Biztory\Storefront\Http\Controllers\CartController;
use Biztory\Storefront\Http\Controllers\CouponController;
use Biztory\Storefront\Http\Controllers\OrderController;
use Biztory\Storefront\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/'.config('app.name').'/storefront')->middleware(['api', 'auth:sanctum', 'api-data-response'])->group(function () {

    Route::controller(CartController::class)->prefix('cart')
        ->group(function () {
            Route::get('', 'get');
            Route::post('', 'set');
        });

    // route for CouponController
    Route::controller(CouponController::class)->prefix('coupons')
        ->group(function () {
            Route::get('', 'index');
        });

    // route for SettingController
    Route::controller(SettingController::class)->prefix('settings')
        ->group(function () {
            Route::get('', 'get');
            Route::patch('', 'set');
        });

    // route for OrderController
    Route::controller(OrderController::class)->prefix('orders')
        ->group(function () {
            Route::post('', 'store');
        });
});
