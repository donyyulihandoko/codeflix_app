<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;



Route::controller(MovieController::class)->group(function () {
    Route::get('/', 'index')->middleware(['auth', 'device_limit']);
    Route::get('movies', 'all')->name('movies.index');
    Route::get('/movies/search', 'search')->name('movies.search');
    Route::get('/movies/{movie:slug}', 'detailMovie')->name('movies.show');
});




// routing untuk override di fortify untuk menambahkan middleware
Route::post('/logout', function (Request $request) {
    // laravel fortify yang menangani logout kita hanya menambah middleware
    return app(AuthenticatedSessionController::class)->destroy($request);
})->name('logout')->middleware(['auth', 'logout_device']);

Route::get('/subscribe/plans', [SubscribeController::class, 'showPlans'])->name('subscribe.plans');
Route::get('/subscribe/plan/{plan}', [SubscribeController::class, 'checkoutPlan'])->name('subscribe.checkout');
Route::post('/subscribe/checkout', [SubscribeController::class, 'processCheckoutPlan'])->name('subscribe.process');
Route::get('/subscribe/success', [SubscribeController::class, 'checkoutSuccess'])->name('subscribe.success');

// routing controller CategoryController
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');


Route::get('/test-expired', function () {
    $membership = \App\Models\Membership::find(1);
    event(new \App\Events\MembershipHasExpired($membership));

    return 'Event fired';
});
