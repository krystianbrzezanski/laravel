<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
    /* 1. Całe tło na czarno */
    body, html, .min-h-screen { 
        background-color: #000000 !important; 
        color: #ffffff !important; 
    }

    /* 2. Nawigacja (pasek na górze) */
    nav { 
        background-color: #050505 !important; 
        border-bottom: 2px solid #8b5cf6 !important; 
    }

    /* 3. Logo - wymuszamy widoczność */
    .flex.shrink-0.items-center a, .font-black { 
        color: #8b5cf6 !important; 
        display: block !important;
        visibility: visible !important;
    }

    /* 4. Naprawa białych kart (np. w Dashboardzie) */
    .bg-white { 
        background-color: #111111 !important; 
        color: #ffffff !important; 
        border: 1px solid #2d2d2d !important;
    }

    /* 5. Teksty na biało */
    .text-gray-800, .text-gray-600, .text-gray-400 { 
        color: #f3f4f6 !important; 
    }
</style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>