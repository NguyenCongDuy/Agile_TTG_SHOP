<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductVariantController;
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
    return redirect()->route('client.home');
})->name('client');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Client Routes
Route::prefix('client')->name('client.')->group(function () {
    // Home
    Route::get('/', [ClientController::class, 'home'])->name('home');

    // Products & Categories
    Route::prefix('products')->group(function () {
        Route::get('/', [ClientController::class, 'products'])->name('products');
        Route::get('/{slug}', [ClientController::class, 'product'])->name('product');
    });

    Route::prefix('category')->group(function () {
        Route::get('/', [ClientController::class, 'categories'])->name('categories');
        Route::get('/{slug}', [ClientController::class, 'category'])->name('category');
    });

    // Search
    Route::get('/search', [ClientController::class, 'search'])->name('search');

    // Cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [ClientController::class, 'cart'])->name('cart');
        Route::post('/add', [ClientController::class, 'addToCart'])->name('cart.add');
        Route::post('/update', [ClientController::class, 'updateCart'])->name('cart.update');
        Route::post('/remove', [ClientController::class, 'removeFromCart'])->name('cart.remove');
    });

    // Contact
    Route::get('/contact', [ClientController::class, 'contact'])->name('contact');
    Route::post('/contact', [ClientController::class, 'sendContact'])->name('contact.send');

    // User Profile & Orders - Authenticated Routes
    Route::middleware(['auth'])->group(function () {
        // User Profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [ClientController::class, 'profile'])->name('profile');
            Route::get('/change-password', [ClientController::class, 'showChangePasswordForm'])->name('change-password');
            Route::post('/change-password', [ClientController::class, 'changePassword']);
        });

        // Orders
        Route::prefix('orders')->group(function () {
            Route::get('/', [ClientController::class, 'orders'])->name('orders');
            Route::get('/{id}', [ClientController::class, 'orderDetails'])->name('orders.detail');
            Route::post('/{order}/cancel', [ClientController::class, 'cancelOrder'])->name('orders.cancel');
            Route::post('/{order}/confirm', [ClientController::class, 'confirmOrder'])->name('orders.confirm');
            Route::post('/{order}/rate', [ClientController::class, 'rateOrder'])->name('orders.rate');
        });

        // Checkout
        Route::prefix('checkout')->group(function () {
            Route::get('/', [ClientController::class, 'checkout'])->name('checkout');
            Route::post('/', [ClientController::class, 'storeOrder'])->name('checkout.store');
        });
    });
});


// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.home');
    })->name('home');

    // Product Management
    Route::prefix('product')->group(function () {
        // Basic Product Routes
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('/', [ProductsController::class, 'store'])->name('products.store');
        Route::get('/inventory', [ProductsController::class, 'inventory'])->name('products.inventory');
        Route::get('/{product}', [ProductsController::class, 'show'])->name('products.show');
        Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
        Route::put('/{product}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');

        // Product Attributes
        Route::get('/{product}/attributes', [ProductsController::class, 'attributes'])->name('products.attributes');
        Route::post('/{product}/attributes', [ProductsController::class, 'updateAttributes'])->name('products.attributes.update');

        // Product Variants
        Route::prefix('{product}/variants')->group(function () {
            Route::get('/', [ProductVariantController::class, 'index'])->name('products.variants.index');
            Route::get('/create', [ProductVariantController::class, 'create'])->name('products.variants.create');
            Route::post('/', [ProductVariantController::class, 'store'])->name('products.variants.store');
            Route::get('/{variant}/edit', [ProductVariantController::class, 'edit'])->name('products.variants.edit');
            Route::put('/{variant}', [ProductVariantController::class, 'update'])->name('products.variants.update');
            Route::delete('/{variant}', [ProductVariantController::class, 'destroy'])->name('products.variants.destroy');
        });
    });

    // Attribute Management
    Route::prefix('attributes')->group(function () {
        Route::get('/', [ProductAttributeController::class, 'index'])->name('attributes.index');
        Route::get('/create', [ProductAttributeController::class, 'create'])->name('attributes.create');
        Route::post('/', [ProductAttributeController::class, 'store'])->name('attributes.store');
        Route::post('/positions', [ProductAttributeController::class, 'updatePositions'])->name('attributes.positions');
        Route::get('/{attribute}/edit', [ProductAttributeController::class, 'edit'])->name('attributes.edit');
        Route::put('/{attribute}', [ProductAttributeController::class, 'update'])->name('attributes.update');
        Route::delete('/{attribute}', [ProductAttributeController::class, 'destroy'])->name('attributes.destroy');

        // Attribute Values
        Route::get('/{attribute}/values', [ProductAttributeController::class, 'values'])->name('attributes.values');
        Route::post('/{attribute}/values', [ProductAttributeController::class, 'storeValue'])->name('attributes.values.store');
    });

    // Attribute Values Routes
    Route::prefix('attribute-values')->group(function () {
        Route::put('/{value}', [ProductAttributeController::class, 'updateValue'])->name('attribute-values.update');
        Route::delete('/{value}', [ProductAttributeController::class, 'destroyValue'])->name('attribute-values.destroy');
    });

    // Category Management
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    });

    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.index');
        Route::get('/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/', [UsersController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::get('/{user}/roles', [UsersController::class, 'roles'])->name('users.roles');
        Route::put('/{user}/roles', [UsersController::class, 'updateRoles'])->name('users.updateRoles');
    });

    // Order Management
    Route::prefix('orders')->group(function () {
        Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('orders.dashboard');
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });

    // Statistics
    Route::prefix('statistics')->group(function () {
        Route::get('/overview', [StatisticsController::class, 'overview'])->name('statistics.overview');
        Route::get('/sales', [StatisticsController::class, 'sales'])->name('statistics.sales');
        Route::get('/products', [StatisticsController::class, 'products'])->name('statistics.products');
    });

    // Contact Management
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts/{id}/process', [ContactController::class, 'markAsProcessed'])->name('contacts.process');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});

require __DIR__ . '/auth.php';

