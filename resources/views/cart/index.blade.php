<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mój Koszyk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 md:p-12">

    <div class="max-w-4xl mx-auto">
        <header class="mb-12 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-black text-gray-900">Twój Koszyk</h1>
                <a href="{{ route('home') }}" class="text-indigo-600 font-bold hover:underline">← Wróć do zakupów</a>
            </div>
        </header>

        {{-- Komunikaty o sukcesie --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-2xl font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="p-6 text-xs font-bold uppercase text-gray-400">Produkt</th>
                            <th class="p-6 text-xs font-bold uppercase text-gray-400 text-center">Ilość</th>
                            <th class="p-6 text-xs font-bold uppercase text-gray-400 text-right">Cena brutto</th>
                            <th class="p-6 text-xs font-bold uppercase text-gray-400 text-center">Akcja</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr>
                                <td class="p-6 flex items-center gap-4">
                                    @if($details['image'])
                                        <img src="{{ asset('storage/' . $details['image']) }}" class="w-16 h-16 object-cover rounded-xl">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <span class="font-bold text-gray-800 text-lg">{{ $details['name'] }}</span>
                                </td>
                                
                                {{-- KOLUMNA Z ILOŚCIĄ I PRZYCISKAMI --}}
                                <td class="p-6">
                                    <div class="flex items-center justify-center gap-3">
                                        {{-- Przycisk Minus --}}
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] - 1 }}">
                                            <button type="submit" 
                                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 border border-gray-100 text-gray-600 font-bold hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ $details['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>
                                                -
                                            </button>
                                        </form>

                                        <span class="font-black text-gray-900 w-8 text-center text-lg">{{ $details['quantity'] }}</span>

                                        {{-- Przycisk Plus --}}
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                            <button type="submit" 
                                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 border border-gray-100 text-gray-600 font-bold hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </td>

                                <td class="p-6 text-right font-black text-indigo-600 text-lg whitespace-nowrap">
                                    {{ number_format($details['price'] * $details['quantity'], 2) }} PLN
                                </td>

                                {{-- PRZYCISK USUWANIA --}}
                                <td class="p-6 text-center">
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="0">
                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-8 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Suma całkowita</p>
                        <p class="text-4xl font-black text-gray-900">{{ number_format($total, 2) }} PLN</p>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-5 rounded-3xl font-bold shadow-xl shadow-indigo-200 transition-all active:scale-95 text-center text-lg">
                        Przejdź do kasy
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center border border-dashed border-gray-200">
                <p class="text-gray-400 text-xl font-medium">Twój koszyk jest jeszcze pusty.</p>
                <a href="{{ route('home') }}" class="inline-block mt-6 bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-colors">
                    Dodaj pierwsze produkty
                </a>
            </div>
        @endif
    </div>

</body>
</html>