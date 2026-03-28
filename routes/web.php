<?php

use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// 1. NAPRAWA STRONY GŁÓWNEJ (Dostarcza $categories i $products)
Route::get('/', function () {
    return view('welcome', [
        'categories' => Category::all(),
        'products' => Product::all()
    ]);
});

// 2. NAPRAWA BŁĘDU cart.index (Tworzy brakującą trasę koszyka)
Route::get('/koszyk', function () {
    // Jeśli nie masz jeszcze widoku cart/index, możesz tymczasowo zwrócić tekst:
    // return "Tu będzie Twój koszyk";
    return view('cart.index'); 
})->name('cart.index');

// 3. TRASA DODAWANIA DO KOSZYKA
Route::post('/cart/add/{id}', function ($id) {
    // Logika koszyka (na razie prosty powrót)
    return back()->with('success', 'Produkt dodany do koszyka!');
})->name('cart.add');

// 4. TRASY BREEZE (Dashboard i Profile)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 5. ŁADOWANIE SYSTEMU LOGOWANIA
require __DIR__.'/auth.php';