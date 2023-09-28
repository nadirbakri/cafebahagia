<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
    Route::delete('/delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');
    Route::post('/store', [App\Http\Controllers\ProductController::class, 'store'])->name('store');
    Route::put('/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
});

Route::prefix('transaction')->name('transaction.')->group(function () {
    Route::get('/', [App\Http\Controllers\TransactionController::class, 'index'])->name('index');
    Route::post('/store/{id}', [App\Http\Controllers\TransactionController::class, 'store'])->name('store');
});