<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mój Sklep</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    {{-- SEKCJA POWIADOMIEŃ (SUCCESS MESSAGE) --}}
    @if(session('success'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] w-full max-w-xl px-6">
            <div class="bg-green-600 text-white px-6 py-4 rounded-3xl shadow-2xl flex items-center justify-between animate-bounce">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="hover:opacity-70 transition-opacity">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-12">
                <a href="/" class="text-2xl font-black text-gray-900 tracking-tighter">SKLEP<span class="text-indigo-600">.</span></a>
                
                <div class="hidden md:flex items-center gap-6">
                    <a href="/" class="text-sm font-bold {{ !request('category') ? 'text-indigo-600' : 'text-gray-500 hover:text-gray-900' }}">Wszystko</a>
                    @foreach($categories as $category)
                        <a href="/?category={{ $category->slug }}&sort={{ request('sort') }}" 
                           class="text-sm font-bold {{ request('category') == $category->slug ? 'text-indigo-600' : 'text-gray-500 hover:text-gray-900' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
<div class="hidden md:flex items-center gap-4 mr-4">
    <a href="/admin/login" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Panel Admina</a>
    <span class="text-gray-300">|</span>
    <a href="/login" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Zaloguj</a>
    <a href="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Zarejestruj</a>
</div>
            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-2xl transition-colors relative group">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-lg border-2 border-white">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto p-6 md:p-12">
        
        <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-gray-900">
                    @if(request('category'))
                        Kategoria: {{ $categories->firstWhere('slug', request('category'))->name ?? 'Produkty' }}
                    @else
                        Nasze Produkty
                    @endif
                </h1>
                <p class="text-gray-500 mt-2">Znaleziono {{ $products->count() }} produktów</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sortuj:</span>
                <select onchange="window.location.href=this.value" class="text-xs font-bold text-gray-900 uppercase cursor-pointer focus:outline-none bg-transparent">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort') == 'latest' ? 'selected' : '' }}>Nowości</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Cena: rosnąco</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Cena: malejąco</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nazwa: A-Z</option>
                </select>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($products as $product)
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                    
                    <div class="aspect-square bg-gray-100 overflow-hidden relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-8">
                        <div class="mb-2">
                            <span class="text-indigo-600 text-xs font-bold uppercase tracking-widest">
                                {{ $product->category->name ?? 'Ogólna' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h2>
                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase">Dostępny</span>
                        </div>
                        
                        <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-2">
                            {{ $product->description }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Cena Brutto</p>
                                <p class="text-3xl font-black text-indigo-600">
                                    {{ number_format($product->price_brutto, 2) }} <span class="text-lg">PLN</span>
                                </p>
                            </div>
                            
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100 transition-all hover:scale-110 active:scale-95">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>