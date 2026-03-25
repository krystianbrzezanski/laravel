<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizacja zamówienia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 md:p-12">
    <div class="max-w-3xl mx-auto">
        <header class="mb-12">
            <a href="{{ route('cart.index') }}" class="text-indigo-600 font-bold hover:underline">← Wróć do koszyka</a>
            <h1 class="text-4xl font-black text-gray-900 mt-4">Dane do wysyłki</h1>
        </header>

        {{-- Formularz wysyła dane do metody store w CheckoutController --}}
        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">
                
                {{-- Imię i Nazwisko --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Imię i Nazwisko</label>
                    <input type="text" name="customer_name" required autocomplete="name"
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                {{-- E-mail --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">E-mail</label>
                    <input type="email" name="email" required autocomplete="email"
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                {{-- Adres --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Adres (ulica i numer)</label>
                    <input type="text" name="address" required autocomplete="street-address"
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                {{-- Miasto i Kod Pocztowy --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Miasto</label>
                        <input type="text" name="city" required autocomplete="address-level2"
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Kod pocztowy</label>
                        {{-- Zmienione na tekst z patternem, żeby wymusić format 00-000 --}}
                        <input type="text" name="zip_code" required 
                            pattern="[0-9]{2}-[0-9]{3}" 
                            title="Kod pocztowy musi być w formacie 00-000"
                            placeholder="00-000"
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                </div>
            </div>

            {{-- Podsumowanie płatności --}}
            <div class="p-4 text-center">
                <p class="text-gray-500 text-sm">Klikając przycisk poniżej, składasz zamówienie z obowiązkiem zapłaty.</p>
            </div>

            <button type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-6 rounded-3xl font-bold text-lg shadow-xl shadow-indigo-200 transition-all active:scale-[0.98]">
                Zamawiam i płacę
            </button>
        </form>
    </div>
</body>
</html>