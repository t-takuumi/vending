<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductShowController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');

Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

Route::get('/products/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');

Route::delete('/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');

Route::put('/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');

Route::post('/products', [App\Http\Controllers\ProductController::class, 'productSubmit'])->name('submit');
