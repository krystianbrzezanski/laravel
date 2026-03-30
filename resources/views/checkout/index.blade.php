<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizacja Zamówienia - Warzywniak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black p-6 md:p-12"> {{-- Tło białe --}}
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-black mb-12 text-black italic tracking-tighter">
            Podsumowanie <span class="text-emerald-600">i dostawa</span>
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            {{-- Lewa kolumna - Formularz --}}
            <div class="bg-gray-50 p-8 rounded-3xl shadow-2xl border border-gray-100">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-widest">Imię i Nazwisko</label>
                            <input type="text" name="customer_name" value="{{ auth()->user()->name }}" required 
                                class="w-full bg-white border border-gray-200 text-black rounded-xl p-4 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-widest">Ulica i numer</label>
                            <input type="text" name="address" required 
                                class="w-full bg-white border border-gray-200 text-black rounded-xl p-4 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-widest">Kod pocztowy i Miasto</label>
                            <input type="text" name="city" required 
                                class="w-full bg-white border border-gray-200 text-black rounded-xl p-4 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all shadow-sm">
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-10 bg-emerald-600 text-white font-black uppercase tracking-tighter py-5 rounded-2xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100 active:scale-95">
                        Złóż zamówienie i zapłać →
                    </button>
                </form>
            </div>

            {{-- Prawa kolumna - Produkty --}}
            <div class="space-y-4">
                <h3 class="text-xl font-black text-black italic tracking-tighter mb-6">Twoje Produkty</h3>
                
                @if(isset($cart) && count($cart) > 0)
                    @foreach($cart as $item)
                        <div class="flex items-center justify-between bg-gray-50 p-5 rounded-2xl border border-gray-100 hover:border-emerald-200 transition-colors">
                            <div>
                                <p class="font-bold text-black">{{ $item['name'] ?? 'Produkt' }}</p>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">
                                    {{ $item['quantity'] ?? 1 }} szt. x {{ number_format($item['price'] ?? 0, 2) }} PLN
                                </p>
                            </div>
                            <p class="font-black text-emerald-600 text-lg italic tracking-tighter">
                                {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }} PLN
                            </p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-400">Brak produktów.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>