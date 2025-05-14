<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// Example: Admin-only route
Route::get('/admin', function () {
    if (!Auth::check() || !in_array(Auth::user()->role, ['admin'])) {
        abort(403, 'Unauthorized.');
    }
    return view('dashboard');
});

// Redirect /admin to the admin dashboard
Route::middleware(['auth', 'rolecheck:admin'])->get('/admin', function() {
    return redirect()->route('admin.dashboard');
});

// Example: IT/Commercial-only route
Route::get('/it', function () {
    if (!Auth::check() || !in_array(Auth::user()->role, ['it', 'admin'])) {
        abort(403, 'Unauthorized.');
    }
    return view('dashboard');
});

// Redirect /orders to /orders/history for client users
Route::get('/orders', function() {
    return redirect('/orders/history');
})->middleware(['auth']);

// Product filtering by category (public, for all users)
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');

// Cart routes
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Product management routes (admin/it only)
Route::middleware(['auth', 'rolecheck:admin,it'])->group(function () {
    Route::resource('products', ProductController::class);
});

// AJAX review routes
Route::middleware('auth')->post('/products/{product}/review', [ProductController::class, 'submitReview'])->name('products.review');
Route::get('/products/{product}/reviews', [ProductController::class, 'getReviews'])->name('products.getReviews');

// Quick view product details (AJAX)
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [CartController::class, 'placeOrder'])->name('cart.placeOrder');
    Route::get('/orders/history', [CartController::class, 'orderHistory'])->name('orders.history');
});

// Event/Salon image management routes
Route::middleware(['auth', 'rolecheck:it,admin'])->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
});
Route::middleware(['auth', 'rolecheck:admin'])->group(function () {
    Route::get('/events/pending', [EventController::class, 'pending'])->name('events.pending');
    Route::post('/events/{event}/approve', [EventController::class, 'approve'])->name('events.approve');
    Route::post('/events/{event}/reject', [EventController::class, 'reject'])->name('events.reject');
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Admin user management
    Route::get('/admin/users', [\App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users');
    Route::delete('/admin/users/{id}', [\App\Http\Controllers\AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});
// Public route to view approved events
Route::get('/events/gallery', [EventController::class, 'gallery'])->name('events.gallery');

require __DIR__.'/auth.php';
