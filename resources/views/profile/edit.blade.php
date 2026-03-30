<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-4xl text-black italic tracking-tighter uppercase">
            Ustawienia <span class="text-emerald-600">Profilu</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-white"> {{-- Główne tło strony na biało --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Sekcja: Informacje o profilu --}}
            <div class="p-8 bg-gray-50 border border-gray-100 shadow-2xl rounded-3xl transition-all hover:border-emerald-200">
                <div class="max-w-xl text-black">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Sekcja: Zmiana hasła --}}
            <div class="p-8 bg-gray-50 border border-gray-100 shadow-2xl rounded-3xl transition-all hover:border-emerald-200">
                <div class="max-w-xl text-black">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Sekcja: Usuwanie konta --}}
            <div class="p-8 bg-red-50/30 border border-red-100 shadow-xl rounded-3xl transition-all hover:border-red-200">
                <div class="max-w-xl text-black">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>