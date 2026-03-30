<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twój Koszyk - JERZOSHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black p-6 md:p-12 font-sans"> {{-- Tło białe --}}

    <div class="max-w-4xl mx-auto">
        <header class="mb-12 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-black italic tracking-tighter text-black">TWÓJ <span class="text-emerald-600">KOSZYK</span></h1>
                <a href="{{ route('home') }}" class="text-emerald-600 font-bold hover:text-emerald-500 transition-colors flex items-center gap-2 mt-2">
                    ← Wróć do zakupów
                </a>
            </div>
        </header>

        {{-- Komunikaty o sukcesie w kolorystyce zielonej --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-500/50 text-emerald-700 px-4 py-3 rounded-2xl font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="p-6 text-xs font-bold uppercase text-gray-400 tracking-widest">Produkt</th>
                            <th class="p-6 text-xs font-bold uppercase text-gray-400 tracking-widest text-center">Ilość</th>
                            <th class="p-6 text-xs font-bold uppercase text-gray-400 tracking-widest text-right">Cena</th>
                            <th class="p-6 text-xs font-bold uppercase text-gray-400 tracking-widest text-center">Usuń</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-6 flex items-center gap-4">
                                    @if($details['image'])
                                        <img src="{{ asset('storage/' . $details['image']) }}" class="w-16 h-16 object-cover rounded-xl border border-gray-100">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <span class="font-bold text-black text-lg">{{ $details['name'] }}</span>
                                </td>
                                
                                <td class="p-6">
                                    <div class="flex items-center justify-center gap-3">
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] - 1 }}">
                                            <button type="submit" 
                                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 border border-gray-200 text-black font-bold hover:bg-emerald-600 hover:text-white transition-all {{ $details['quantity'] <= 1 ? 'opacity-30 cursor-not-allowed' : '' }}"
                                                {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>
                                                -
                                            </button>
                                        </form>

                                        <span class="font-black text-black w-8 text-center text-lg">{{ $details['quantity'] }}</span>

                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                            <button type="submit" 
                                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 border border-gray-200 text-black font-bold hover:bg-emerald-600 hover:text-white transition-all">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </td>

                                <td class="p-6 text-right font-black text-emerald-600 text-lg whitespace-nowrap">
                                    {{ number_format($details['price'] * $details['quantity'], 2) }} PLN
                                </td>

                                <td class="p-6 text-center">
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="0">
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-all transform hover:scale-110">
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

                <div class="p-8 bg-gray-50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Suma do zapłaty</p>
                        <p class="text-4xl font-black text-black italic tracking-tighter">{{ number_format($total, 2) }} <span class="text-emerald-600 italic">PLN</span></p>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-12 py-5 rounded-2xl font-black uppercase tracking-tighter shadow-xl shadow-emerald-100 transition-all hover:scale-105 active:scale-95 text-center text-lg">
                        Przejdź do kasy →
                    </a>
                </div>
            </div>
        @else
            <div class="bg-gray-50 rounded-3xl p-16 text-center border border-gray-100 shadow-2xl">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300 shadow-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <p class="text-gray-500 text-xl font-medium mb-8">Twój koszyk jest jeszcze pusty.</p>
                <a href="{{ route('home') }}" class="inline-block bg-emerald-600 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-tighter hover:bg-emerald-700 transition-all hover:scale-105">
                    Zacznij zakupy
                </a>
            </div>
        @endif
    </div>

</body>
</html>