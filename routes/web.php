<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Welcome'));
Route::get('/orders', fn () => Inertia::render('Orders', ['orders' => []]));
Route::get('/orders/sync', function () {
    // Здесь позже подключим синхронизацию заказов
    return redirect('/orders');
});
