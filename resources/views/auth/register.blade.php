<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-black italic tracking-tighter uppercase">
            Dołącz do <span class="text-emerald-600">nas</span>
        </h2>
        <p class="text-gray-400 text-sm mt-2 font-medium">Stwórz swoje konto w Warzywniaku</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Imię i Nazwisko --}}
        <div>
            <x-input-label for="name" :value="__('Imię i Nazwisko')" class="text-gray-400 font-bold uppercase text-xs tracking-widest mb-1" />
            <x-text-input id="name" class="block mt-1 w-full bg-white border-gray-200 text-black focus:border-emerald-500 focus:ring-emerald-500 shadow-sm rounded-xl p-3" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-400 font-bold uppercase text-xs tracking-widest mb-1" />
            <x-text-input id="email" class="block mt-1 w-full bg-white border-gray-200 text-black focus:border-emerald-500 focus:ring-emerald-500 shadow-sm rounded-xl p-3" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        {{-- Hasło --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Hasło')" class="text-gray-400 font-bold uppercase text-xs tracking-widest mb-1" />
            <x-text-input id="password" class="block mt-1 w-full bg-white border-gray-200 text-black focus:border-emerald-500 focus:ring-emerald-500 shadow-sm rounded-xl p-3"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        {{-- Potwierdź hasło --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Potwierdź hasło')" class="text-gray-400 font-bold uppercase text-xs tracking-widest mb-1" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white border-gray-200 text-black focus:border-emerald-500 focus:ring-emerald-500 shadow-sm rounded-xl p-3"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="text-sm text-gray-400 hover:text-emerald-600 transition-colors font-bold" href="{{ route('login') }}">
                {{ __('Masz już konto?') }}
            </a>

            <button type="submit" class="ms-4 bg-emerald-600 hover:bg-emerald-700 text-white py-4 px-8 rounded-2xl font-black uppercase tracking-tighter transition-all shadow-lg shadow-emerald-100 active:scale-95">
                {{ __('Zarejestruj się') }}
            </button>
        </div>
    </form>
</x-guest-layout>