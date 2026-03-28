<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Finalizacja Zamówienia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto p-12">
        <h1 class="text-4xl font-black mb-8 text-gray-900">Podsumowanie <span class="text-indigo-600">i dostawa</span></h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Imię i Nazwisko</label>
                            <input type="text" name="customer_name" value="{{ auth()->user()->name }}" required class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-indigo-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ulica i numer</label>
                            <input type="text" name="address" required class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-indigo-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Kod pocztowy i Miasto</label>
                            <input type="text" name="city" required class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-indigo-600">
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-8 bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                        Złóż zamówienie i zapłać
                    </button>
                </form>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-800">Twoje Produkty</h3>
                @foreach($cart as $item)
                <div class="flex items-center justify-between bg-white p-4 rounded-2xl border border-gray-100">
                    <div>
                        <p class="font-bold text-gray-900">{{ $item['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $item['quantity'] }} szt. x {{ number_format($item['price'], 2) }} PLN</p>
                    </div>
                    <p class="font-black text-indigo-600">{{ number_format($item['price'] * $item['quantity'], 2) }} PLN</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>