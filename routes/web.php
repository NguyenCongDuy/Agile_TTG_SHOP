<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

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

// Dashboard
Route::get('/', function () {
    return view('admin.home');
})->name('dashboard');

Route::prefix('/admin')->group(function () {
    // Product Routes
    Route::get('/product', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/product/create', [ProductsController::class, 'create'])->name('products.create');
    Route::get('/product/inventory', [ProductsController::class, 'inventory'])->name('products.inventory');
    Route::delete('/product/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');

    // Category Routes
    Route::get('/category', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/category/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('/category', [CategoriesController::class, 'store'])->name('categories.store');

    // User Routes
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/roles', [UsersController::class, 'roles'])->name('users.roles');

    // Statistics Routes
    Route::get('/statistics/overview', [StatisticsController::class, 'overview'])->name('statistics.overview');
    Route::get('/statistics/sales', [StatisticsController::class, 'sales'])->name('statistics.sales');
    Route::get('/statistics/products', [StatisticsController::class, 'products'])->name('statistics.products');
});
