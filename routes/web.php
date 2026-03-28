<?php

use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 1. NAPRAWA STRONY GŁÓWNEJ (Dostarcza $categories i $products)
Route::get('/', function (Request $request) {
    $query = Product::query();

    // Filtrowanie po kategorii
    if ($request->has('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    // Sortowanie
    switch ($request->sort) {
        case 'price_asc': $query->orderBy('price_brutto', 'asc'); break;
        case 'price_desc': $query->orderBy('price_brutto', 'desc'); break;
        case 'name_asc': $query->orderBy('name', 'asc'); break;
        default: $query->latest(); break;
    }

    return view('welcome', [
        'categories' => Category::all(),
        'products' => $query->get()
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
    $product = \App\Models\Product::findOrFail($id);
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price_brutto,
            "image" => $product->image
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Produkt dodany do koszyka!');
})->name('cart.add');

Route::get('/cart', function () {
    return view('cart.index'); // Tu wyświetlimy zawartość sesji 'cart'
})->name('cart.index');

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