<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController,
    CategoryController,
    UserController,
    LogController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //products
    Route::resource('/products', ProductController::class);
    //stock
    Route::get('/stock/{product}', [ProductController::class, 'stock'])->name('stock');
    //stock store
    Route::post('/stock', [ProductController::class, 'stockStore'])->name('stock.store');
    //stock reportes
    Route::post('/stock/report', [ProductController::class, 'stockReport'])->name('stock.report');

    //category
    Route::resource('/categories', CategoryController::class);
    //users
    Route::resource('/users', UserController::class);
    //passUpdate
    Route::put('/passUpdate', [UserController::class, 'passUpdate'])->name('users.passUpdate');
    //enabled
    Route::put('/enabled/{id}', [UserController::class, 'enabled'])->name('users.enabled');
    //disabled
    Route::put('/disabled/{id}', [UserController::class, 'disabled'])->name('users.disabled');

    //logs
    Route::get('/logs', [LogController::class, 'logs'])->name('logs');
});

require __DIR__.'/auth.php';
