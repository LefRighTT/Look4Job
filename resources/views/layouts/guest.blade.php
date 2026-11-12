<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', v => localStorage.setItem('darkMode', v))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <style>
            [x-cloak] { display: none !important; }
            @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
            .fade-up { animation: fadeUp .45s ease-out both; }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100">
        <div class="relative min-h-screen flex flex-col items-center justify-center px-4 py-10
                    bg-gradient-to-b from-indigo-50 via-white to-white
                    dark:from-gray-900 dark:via-gray-900 dark:to-gray-950">

            <button @click="darkMode = !darkMode" type="button" aria-label="Toggle dark mode"
                    class="absolute top-4 right-4 p-2 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </button>

            <a href="/" class="flex items-center gap-2 mb-8 fade-up">
                <x-application-logo class="w-9 h-9 fill-current text-indigo-600" />
                <span class="font-bold text-xl tracking-tight">{{ config('app.name', 'JobBoard') }}</span>
            </a>

            <div class="fade-up w-full sm:max-w-md bg-white dark:bg-gray-800 rounded-2xl p-8
                        shadow-xl shadow-indigo-100/60 dark:shadow-none ring-1 ring-gray-100 dark:ring-gray-700">
                {{ $slot }}
            </div>

            <p class="mt-6 text-xs text-gray-400 dark:text-gray-500">Find work that fits. Hire people who do.</p>
        </div>
    </body>
</html>
