<?php

use App\Http\Controllers\SubscribeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/subscribe/plans', [SubscribeController::class, 'showPlans'])->name('subscribe.plans');
Route::get('/subscribe/plan/{plan}', [SubscribeController::class, 'checkoutPlan'])->name('subscribe.checkout');
Route::post('/subscribe/checkout', [SubscribeController::class, 'processCheckoutPlan'])->name('subscribe.process');
Route::get('/subscribe/success', [SubscribeController::class, 'checkoutSuccess'])->name('subscribe.success');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'check.device.middleware']);

// override logout didalam laravel fortify dengan middleware
Route::get('/logout', function (Request $request) {
    return app(AuthenticatedSessionController::class)->destroy($request);
})->middleware(['auth', 'logout.device']);
