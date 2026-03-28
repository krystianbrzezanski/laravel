<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. STRONA GŁÓWNA (Naprawia błąd Undefined variable $categories) ---
Route::get('/', function (Request $request) {
    $query = Product::query();

    // Filtrowanie po kategorii (Slug)
    if ($request->has('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    // Sortowanie po 'price' (kolumna w bazie, naprawia błąd 500)
    switch ($request->sort) {
        case 'price_asc': 
            $query->orderBy('price', 'asc'); 
            break;
        case 'price_desc': 
            $query->orderBy('price', 'desc'); 
            break;
        case 'name_asc': 
            $query->orderBy('name', 'asc'); 
            break;
        default: 
            $query->latest(); 
            break;
    }

    return view('welcome', [
        'categories' => Category::all(), // Kluczowe dla menu górnego
        'products' => $query->get()
    ]);
})->name('home');

// --- 2. KOSZYK (Podpięcie Twojego CartController) ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// --- 3. KASA (Tymczasowe, zapobiega błędom 404/500) ---
Route::get('/checkout', function() {
    return "Strona finalizacji zamówienia w przygotowaniu.";
})->name('checkout.index');

// --- 4. DASHBOARD (Przekierowanie na home, aby uniknąć błędu 403 po logowaniu) ---
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- 5. PROFIL UŻYTKOWNIKA (Breeze) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- 6. AUTORYZACJA ADMINA ---
Gate::define('access-admin', function ($user) {
    // Zmień ten e-mail na swój docelowy
    return $user->email === 'admin@test.pl';
});

// Zabezpieczenie techniczne prefiksu /admin
Route::middleware(['auth', 'can:access-admin'])->prefix('admin')->group(function () {
    // Tu możesz dodać własne trasy panelu, jeśli nie używasz Filamenta
});

require __DIR__.'/auth.php';