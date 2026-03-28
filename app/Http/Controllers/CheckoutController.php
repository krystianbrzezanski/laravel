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
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Twój koszyk jest pusty!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        // Walidacja danych klienta
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
        ]);

        // Używamy transakcji bazy danych, żeby mieć pewność, że albo zapisze się wszystko, albo nic
        DB::transaction(function () use ($request, $cart) {
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // 1. Tworzymy zamówienie
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'total_brutto' => $total,
                'status' => 'nowe'
            ]);

            // 2. Dodajemy produkty do zamówienia
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $details['name'],
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);
            }
        });

        // 3. Czyścimy koszyk i przekierowujemy
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Dziękujemy! Twoje zamówienie zostało złożone.');
    }
}