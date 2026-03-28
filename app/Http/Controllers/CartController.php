<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price_brutto,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produkt dodany!');
    }

    /**
     * ZAKTUALIZOWANA METODA: Obsługuje zmianę ilości ORAZ usuwanie
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $newQuantity = (int) $request->quantity;
            
            // Jeśli ilość wynosi 0 lub mniej, usuwamy produkt z koszyka
            if($newQuantity <= 0) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Produkt został usunięty z koszyka!');
            }

            // W przeciwnym razie aktualizujemy ilość
            $cart[$id]['quantity'] = $newQuantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Ilość została zmieniona!');
        }

        return redirect()->back()->with('error', 'Wystąpił błąd przy aktualizacji.');
    }
}