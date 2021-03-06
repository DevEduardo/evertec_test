<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\SaleController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::any('sale/detail', [SaleController::class, 'detail'])->name('sale.detail');
Route::post('sale/payment', [SaleController::class, 'payment'])->name('sale.payment');
Route::post('sale/retry/payment', [SaleController::class, 'retryPayment'])->name('sale.retryPayment');
Route::get('/response/{reference}', [SaleController::class, 'response']);

Route::get('orders', [SaleController::class, 'orders'])->name('orders');
require __DIR__.'/auth.php';
