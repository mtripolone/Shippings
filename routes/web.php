<?php

use App\Http\Controllers\ShippingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', function() {
    return redirect('/shippings');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/shippings', [ShippingController::class, 'index'])->name('shippings.index');
    Route::post('/shippings/import', [ShippingController::class, 'store'])->name('shippings.store');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
});

