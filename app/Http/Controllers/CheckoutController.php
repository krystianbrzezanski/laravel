<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

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
    // --- WYMUSZENIE POPRAWKI BAZY (Tylko raz!) ---
    if (!Schema::hasColumn('orders', 'user_id')) {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
    // --------------------------------------------

    $cart = session()->get('cart');
    
    $request->validate([
        'customer_name' => 'required',
        'address' => 'required',
        'city' => 'required',
    ]);

    $order = Order::create([
        'user_id' => auth()->id(),
        'customer_name' => $request->customer_name,
        'email' => auth()->user()->email,
        'address' => $request->address,
        'city' => $request->city,
        'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
    ]);

    foreach($cart as $id => $details) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $id,
            'product_name' => $details['name'],
            'quantity' => $details['quantity'],
            'price' => $details['price'],
        ]);
    }

    session()->forget('cart');
    return redirect()->route('home')->with('success', 'Dziękujemy! Zamówienie złożone.');
}
}