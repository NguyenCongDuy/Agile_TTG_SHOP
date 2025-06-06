<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
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


Route::get('/', function () {
    return view('client.home');
})->middleware(['auth', 'verified'])->name('client');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Client Routes
Route::prefix('client')->group(function () {
    // Home
    Route::get('/', [ClientController::class, 'home'])->name('client.home');

    // Products
    Route::get('/products', [ClientController::class, 'products'])->name('client.products');
    Route::get('/product/{slug}', [ClientController::class, 'product'])->name('client.product');

    // Categories
    Route::get('/categories', [ClientController::class, 'categories'])->name('client.categories');
    Route::get('/category/{slug}', [ClientController::class, 'category'])->name('client.category');

    // Search
    Route::get('/search', [ClientController::class, 'search'])->name('client.search');

    // Cart
    Route::get('/cart', [ClientController::class, 'cart'])->name('client.cart');
    Route::post('/cart/add', [ClientController::class, 'addToCart'])->name('client.cart.add');
    Route::post('/cart/update', [ClientController::class, 'updateCart'])->name('client.cart.update');
    Route::post('/cart/remove', [ClientController::class, 'removeFromCart'])->name('client.cart.remove');

    // User Profile
    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ClientController::class, 'profile'])->name('client.profile');
        Route::get('/orders', [ClientController::class, 'orders'])->name('client.orders');
        Route::get('/orders/{id}', [ClientController::class, 'orderDetails'])->name('client.order.details');
    });

    // Contact
    Route::get('/contact', [ClientController::class, 'contact'])->name('client.contact');
    Route::post('/contact', [ClientController::class, 'sendContact'])->name('client.contact.send');
});



// Admin Routes
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.home');
    })->name('admin.home');

    // Product Routes
    Route::get('/product', [ProductsController::class, 'index'])->name('admin.products.index');
    Route::get('/product/create', [ProductsController::class, 'create'])->name('admin.products.create');
    Route::post('/product', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::get('/product/{product}', [ProductsController::class, 'show'])->name('admin.products.show');
    Route::get('/product/{product}/edit', [ProductsController::class, 'edit'])->name('admin.products.edit');
    Route::put('/product/{product}', [ProductsController::class, 'update'])->name('admin.products.update');
    Route::delete('/product/{product}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/product/inventory', [ProductsController::class, 'inventory'])->name('admin.products.inventory');
    
    // Category Routes
    Route::get('/category', [CategoriesController::class, 'index'])->name('admin.categories.index');
    Route::get('/category/create', [CategoriesController::class, 'create'])->name('admin.categories.create');
    Route::post('/category', [CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::get('/category/{category}/edit', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/category/{category}', [CategoriesController::class, 'update'])->name('admin.categories.update');
    Route::delete('/category/{category}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

    // User Routes
    Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/{user}/roles', [UsersController::class, 'roles'])->name('admin.users.roles');
    Route::put('/users/{user}/roles', [UsersController::class, 'updateRoles'])->name('admin.users.updateRoles');

    // Statistics Routes
    Route::get('/statistics/overview', [StatisticsController::class, 'overview'])->name('admin.statistics.overview');
    Route::get('/statistics/sales', [StatisticsController::class, 'sales'])->name('admin.statistics.sales');
    Route::get('/statistics/products', [StatisticsController::class, 'products'])->name('admin.statistics.products');
});

require __DIR__ . '/auth.php';
