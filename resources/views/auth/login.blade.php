<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-black italic tracking-tighter uppercase">
            Witaj <span class="text-emerald-600">ponownie</span>
        </h2>
        <p class="text-gray-400 text-sm mt-2 font-medium">Zaloguj się do swojego konta</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-400 font-bold uppercase text-xs tracking-widest mb-1" />
            <x-text-input id="email" class="block mt-1 w-full bg-white border-gray-200 text-black focus:border-emerald-500 focus:ring-emerald-500 shadow-sm rounded-xl p-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        {{-- Hasło --}}
        <div class="mt-6">
            <x-input-label for="password" :value="__('Hasło')" class="text-gray-400 font-bold uppercase text-xs tracking-widest mb-1" />
            <x-text-input id="password" class="block mt-1 w-full bg-white border-gray-200 text-black focus:border-emerald-500 focus:ring-emerald-500 shadow-sm rounded-xl p-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        {{-- Zapamiętaj mnie --}}
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 bg-white text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="ms-2 text-sm text-gray-500 font-medium">{{ __('Zapamiętaj mnie') }}</span>
            </label>
        </div>

        {{-- Stopka formularza --}}
        <div class="flex items-center justify-between mt-10">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-400 hover:text-emerald-600 transition-colors font-bold" href="{{ route('password.request') }}">
                    {{ __('Zapomniałeś hasła?') }}
                </a>
            @endif

            <button type="submit" class="ms-3 bg-emerald-600 hover:bg-emerald-700 text-white py-4 px-8 rounded-2xl font-black uppercase tracking-tighter transition-all shadow-lg shadow-emerald-100 active:scale-95">
                {{ __('Zaloguj się') }}
            </button>
        </div>
    </form>
</x-guest-layout>