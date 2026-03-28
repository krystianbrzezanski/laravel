<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// --- STRONA GŁÓWNA (z poprawionym sortowaniem) ---
Route::get('/', function (Request $request) {
    $query = Product::query();

    // Filtrowanie po kategorii
    if ($request->has('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    // Sortowanie (używamy kolumny 'price', bo 'price_brutto' nie istnieje w bazie)
    switch ($request->sort) {
        case 'price_asc': $query->orderBy('price', 'asc'); break;
        case 'price_desc': $query->orderBy('price', 'desc'); break;
        case 'name_asc': $query->orderBy('name', 'asc'); break;
        default: $query->latest(); break;
    }

    return view('welcome', [
        'categories' => Category::all(),
        'products' => $query->get()
    ]);
})->name('home');

// --- KOSZYK (Korzystamy z Twojego CartController) ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// --- KASA (Tymczasowa trasa, by nie było błędu 500) ---
Route::get('/checkout', function() {
    return "Tu będzie finalizacja zamówienia";
})->name('checkout.index');

// --- PANEL UŻYTKOWNIKA (Breeze) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Gate;

// Definiujemy bramkę dostępu (Gate)
Gate::define('access-admin', function ($user) {
    return $user->email === 'admin@test.pl'; // Tu wpisz swój e-mail
});

// Jeśli masz trasy admina w web.php, owiń je tak:
Route::middleware(['auth', 'can:access-admin'])->prefix('admin')->group(function () {
    // Tutaj trafiają wszystkie trasy, które mają być tylko dla Ciebie
});