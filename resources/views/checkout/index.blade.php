<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Finalizacja Zamówienia - JEŻOSHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white"> {{-- Tło zmienione na czarne --}}
    <div class="max-w-4xl mx-auto p-12">
        <h1 class="text-4xl font-black mb-8 text-white italic tracking-tighter">
            Podsumowanie <span class="text-violet-500">i dostawa</span> {{-- Indigo zastąpione fioletem --}}
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            {{-- Lewa kolumna - Formularz --}}
            <div class="bg-zinc-900 p-8 rounded-3xl shadow-2xl border border-zinc-800">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase mb-2 tracking-widest">Imię i Nazwisko</label>
                            <input type="text" name="customer_name" value="{{ auth()->user()->name }}" required 
                                class="w-full bg-zinc-800 border border-zinc-700 text-white rounded-xl p-4 focus:ring-2 focus:ring-violet-500 focus:outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase mb-2 tracking-widest">Ulica i numer</label>
                            <input type="text" name="address" required 
                                class="w-full bg-zinc-800 border border-zinc-700 text-white rounded-xl p-4 focus:ring-2 focus:ring-violet-500 focus:outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase mb-2 tracking-widest">Kod pocztowy i Miasto</label>
                            <input type="text" name="city" required 
                                class="w-full bg-zinc-800 border border-zinc-700 text-white rounded-xl p-4 focus:ring-2 focus:ring-violet-500 focus:outline-none transition-all">
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-10 bg-violet-600 text-white font-black uppercase tracking-tighter py-5 rounded-2xl hover:bg-violet-700 transition-all shadow-xl shadow-violet-900/20 active:scale-95">
                        Złóż zamówienie i zapłać →
                    </button>
                </form>
            </div>

            {{-- Prawa kolumna - Produkty --}}
            <div class="space-y-4">
                <h3 class="text-xl font-black text-zinc-100 italic tracking-tighter mb-6">Twoje Produkty</h3>
                @foreach($cart as $item)
                <div class="flex items-center justify-between bg-zinc-900/50 p-5 rounded-2xl border border-zinc-800 hover:border-zinc-700 transition-colors">
                    <div>
                        <p class="font-bold text-zinc-100">{{ $item['name'] }}</p>
                        <p class="text-xs text-zinc-500 font-medium uppercase tracking-wider">{{ $item['quantity'] }} szt. x {{ number_format($item['price'], 2) }} PLN</p>
                    </div>