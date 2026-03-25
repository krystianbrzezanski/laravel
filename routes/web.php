<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Strona główna - Katalog produktów
Route::get('/', [ProductController::class, 'index'])->name('home');

// KOSZYK
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

// AKTUALIZACJA ILOŚCI W KOSZYKU (Nowe!)
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// CHECKOUT (Finalizacja zamówienia)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');