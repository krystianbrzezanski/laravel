<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JERZOSHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white"> {{-- ZMIANA: Tło strony na czarne --}}

    {{-- SEKCJA POWIADOMIEŃ --}}
    @if(session('success'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] w-full max-w-xl px-6">
            <div class="bg-violet-600 text-white px-6 py-4 rounded-3xl shadow-2xl flex items-center justify-between animate-bounce">
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

    <nav class="bg-zinc-950 border-b border-violet-900/50 sticky top-0 z-50"> {{-- ZMIANA: Ciemna nawi --}}
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-12">
                {{-- ZMIANA: Logo na fioletowo-białe --}}
                <a href="/" class="text-2xl font-black tracking-tighter">
                    <span class="text-violet-500">🦔 JEŻO</span><span class="text-white">SHOP</span><span class="text-violet-500">.</span>
                </a>
                
                <div class="hidden md:flex items-center gap-6">
                    <a href="/" class="text-sm font-bold {{ !request('category') ? 'text-violet-500' : 'text-gray-400 hover:text-white' }}">Wszystko</a>
                    @foreach($categories as $category)
                        <a href="/?category={{ $category->slug }}&sort={{ request('sort') }}" 
                           class="text-sm font-bold {{ request('category') == $category->slug ? 'text-violet-500' : 'text-gray-400 hover:text-white' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4 mr-4">
                @auth
                    @if(auth()->user()->email === 'admin@test.pl') 
                        <a href="/admin" class="text-sm font-bold text-violet-400 hover:text-violet-300">🛡️ Panel Admina</a>
                        <span class="text-zinc-700">|</span>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-300 hover:text-violet-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ auth()->user()->name }}
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline ml-2">
                        @csrf
                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 font-bold">Wyloguj</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-violet-400">Zaloguj się</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-violet-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-violet-700 transition-all">Zarejestruj</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="bg-zinc-900 hover:bg-zinc-800 p-3 rounded-2xl transition-colors relative group border border-violet-900/30">
                    <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-violet-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-lg border-2 border-black">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto p-6 md:p-12">
        
        <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-white"> {{-- ZMIANA: Tytuł na biało --}}
                    @if(request('category'))
                        Kategoria: <span class="text-violet-500">{{ $categories->firstWhere('slug', request('category'))->name ?? 'Produkty' }}</span>
                    @else
                        Nasze <span class="text-violet-500">Produkty</span>
                    @endif
                </h1>
                <p class="text-gray-500 mt-2">Znaleziono {{ $products->count() }} produktów</p>
            </div>
            
            <div class="flex items-center gap-3 bg-zinc-900 px-4 py-2 rounded-xl shadow-sm border border-violet-900/20">
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Sortuj:</span>
                <select onchange="window.location.href=this.value" class="text-xs font-bold text-white uppercase cursor-pointer focus:outline-none bg-transparent">
                    <option class="bg-zinc-900" value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort') == 'latest' ? 'selected' : '' }}>Nowości</option>
                    <option class="bg-zinc-900" value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Cena: rosnąco</option>
                    <option class="bg-zinc-900" value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Cena: malejąco</option>
                    <option class="bg-zinc-900" value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nazwa: A-Z</option>
                </select>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($products as $product)
                <div class="bg-zinc-900 rounded-3xl shadow-sm border border-violet-900/10 overflow-hidden hover:border-violet-500/50 transition-all duration-300 group">
                    
                    <div class="aspect-square bg-zinc-800 overflow-hidden relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-80 group-hover:opacity-100">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-zinc-700">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-8">
                        <div class="mb-2">
                            <span class="text-violet-400 text-xs font-bold uppercase tracking-widest">
                                {{ $product->category->name ?? 'Ogólna' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-2xl font-bold text-white group-hover:text-violet-400 transition-colors">{{ $product->name }}</h2>
                            <span class="bg-violet-900/30 text-violet-400 text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase border border-violet-500/20">Dostępny</span>
                        </div>
                        
                        <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-2">
                            {{ $product->description }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">Cena Brutto</p>
                                <p class="text-3xl font-black text-violet-500">
                                    {{ number_format($product->price_brutto, 2) }} <span class="text-lg text-white">PLN</span>
                                </p>
                            </div>
                            
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-violet-600 hover:bg-violet-500 text-white w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-900/20 transition-all hover:scale-110 active:scale-95">
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