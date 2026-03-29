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
            body, .min-h-screen { background-color: #000000 !important; color: #ffffff !important; }
            nav { background-color: #000000 !important; border-bottom: 1px solid #6d28d9 !important; }
            header { background-color: #111827 !important; border-bottom: 1px solid rgba(109, 40, 217, 0.3) !important; }
            .bg-white { background-color: #1a1a1a !important; color: #ffffff !important; }
            .text-gray-800 { color: #ffffff !important; }
            .shadow { shadow: 0 4px 6px -1px rgba(109, 40, 217, 0.2) !important; }
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