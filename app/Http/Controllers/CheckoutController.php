<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) return redirect()->route('home')->with('error', 'Koszyk jest pusty!');

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart');
        
        // 1. Walidacja danych
        $request->validate([
            'customer_name' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        // 2. Tworzenie zamówienia
        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'email' => auth()->user()->email,
            'address' => $request->address,
            'city' => $request->city,
            'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
        ]);

        // 3. Dodawanie produktów
        foreach($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $details['name'],
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        // 4. Czyszczenie koszyka
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Dziękujemy! Zamówienie zostało złożone.');
    }
}