{{-- View: layouts.guest | Role: guest | Module: Core Layout --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartKids') }}</title>

        <!-- Fonts: Outfit -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-50 via-teal-50/30 to-slate-100 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800">
            <div class="mb-6">
                <a href="/" class="flex items-center space-x-2 group">
                    <div class="w-12 h-12 bg-teal-600 rounded-2xl flex items-center justify-center shadow-xl shadow-teal-200 dark:shadow-teal-900 group-hover:scale-105 transition-transform">
                        <span class="text-white font-bold text-2xl">S</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Smart<span class="text-teal-600">Kids</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-6 bg-white dark:bg-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
