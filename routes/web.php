<?php

use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/product', function () {
    return view('product.create');
})->middleware(['auth', 'verified'])->name('product.create');

// Authenticated Routes Group
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Owner Registration Routes
    Route::get('/register-owner', [OwnerController::class, 'create'])->name('owner.register');
    Route::post('/register-owner', [OwnerController::class, 'store'])->name('owner.store');

    // Product Routes
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

require __DIR__ . '/auth.php';
