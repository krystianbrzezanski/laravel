<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Imię i Nazwisko')" class="text-zinc-400 font-bold uppercase text-xs tracking-widest" />
            <x-text-input id="name" class="block mt-1 w-full bg-zinc-900 border-zinc-800 text-white focus:border-violet-500 focus:ring-violet-500 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-zinc-400 font-bold uppercase text-xs tracking-widest" />
            <x-text-input id="email" class="block mt-1 w-full bg-zinc-900 border-zinc-800 text-white focus:border-violet-500 focus:ring-violet-500 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Hasło')" class="text-zinc-400 font-bold uppercase text-xs tracking-widest" />
            <x-text-input id="password" class="block mt-1 w-full bg-zinc-900 border-zinc-800 text-white focus:border-violet-500 focus:ring-violet-500 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Potwierdź hasło')" class="text-zinc-400 font-bold uppercase text-xs tracking-widest" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-zinc-900 border-zinc-800 text-white focus:border-violet-500 focus:ring-violet-500 shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="underline text-sm text-zinc-500 hover:text-violet-400 transition-colors" href="{{ route('login') }}">
                {{ __('Masz już konto?') }}
            </a>

            <x-primary-button class="ms-4 bg-violet-600 hover