<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-zinc-400 font-bold uppercase text-xs tracking-widest" />
            <x-text-input id="email" class="block mt-1 w-full bg-zinc-900 border-zinc-800 text-white focus:border-violet-500 focus:ring-violet-500 shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <div class="mt-6">
            <x-input-label for="password" :value="__('Hasło')" class="text-zinc-400 font-bold uppercase text-xs tracking-widest" />
            <x-text-input id="password" class="block mt-1 w-full bg-zinc-900 border-zinc-800 text-white focus:border-violet-500 focus:ring-violet-500 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-zinc-800 bg-zinc-900 text-violet-600 shadow-sm focus:ring-violet-500" name="remember">
                <span class="ms-2 text-sm text-zinc-500">{{ __('Zapamiętaj mnie') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-zinc-500 hover:text-violet-400 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Zapomniałeś hasła?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-violet-600 hover:bg-violet-700 active:bg-violet-800 focus:ring-violet-500 py-3 px-6 rounded-xl font-black uppercase tracking-tighter transition-all">
                {{ __('Zaloguj się') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>