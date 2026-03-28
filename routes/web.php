<?php

use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// STRONA GŁÓWNA (z nazwą 'home')
Route::get('/', function (Request $request) {
    $query = Product::query();

    if ($request->has('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    // Sortowanie - sprawdź w bazie czy masz 'price' czy 'price_brutto'
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

// KOSZYK - WYŚWIETLANIE
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');

// KOSZYK - DODAWANIE
Route::post('/cart/add/{id}', function ($id) {
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);
    if(isset($cart[$id])) { $cart[$id]['quantity']++; } 
    else {
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price, // upewnij się co do nazwy kolumny
            "image" => $product->image
        ];
    }
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Produkt dodany!');
})->name('cart.add');

// KOSZYK - AKTUALIZACJA I USUWANIE (To naprawi błąd w Twoim pliku)
Route::patch('/cart/update/{id}', function (Request $request, $id) {
    $cart = session()->get('cart');
    if($request->quantity <= 0) {
        unset($cart[$id]);
    } else {
        $cart[$id]['quantity'] = $request->quantity;
    }
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Koszyk zaktualizowany!');
})->name('cart.update');

// KASA (Tymczasowa trasa, żeby nie było błędu 500)
Route::get('/checkout', function () {
    return "Tu będzie finalizacja zamówienia";
})->name('checkout.index');

// BREEZE & AUTH
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';