<?php

use App\Http\Controllers\SubscribeController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [MovieController::class, 'index'])->middleware(['auth', 'device_limit']);

// routing untuk override di fortify untuk menambahkan middleware
Route::post('/logout', function (Request $request) {
    // laravel fortify yang menangani logout kita hanya menambah middleware
    return app(AuthenticatedSessionController::class)->destroy($request);
})->name('logout')->middleware(['auth', 'logout_device']);

Route::get('/subscribe/plans', [SubscribeController::class, 'showPlans'])->name('subscribe.plans');
Route::get('/subscribe/plan/{plan}', [SubscribeController::class, 'checkoutPlan'])->name('subscribe.checkout');
Route::post('/subscribe/checkout', [SubscribeController::class, 'processCheckoutPlan'])->name('subscribe.process');
Route::get('/subscribe/success', [SubscribeController::class, 'checkoutSuccess'])->name('subscribe.success');
