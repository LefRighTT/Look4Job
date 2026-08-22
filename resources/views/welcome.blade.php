<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', value => localStorage.setItem('darkMode', value))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} — Job Board</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

        <!-- Nav -->
        <header class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-application-logo class="w-8 h-8 fill-current text-indigo-600" />
                    <span class="font-bold text-lg tracking-tight">{{ config('app.name', 'JobBoard') }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                        class="p-2 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                    >
                        <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium hover:text-indigo-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-indigo-600">Log in</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Register</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section class="max-w-6xl mx-auto px-6 pt-20 pb-16">
            <p class="text-sm font-semibold text-indigo-600 tracking-wide uppercase mb-4">
                {{ $openJobsCount }} open position{{ $openJobsCount === 1 ? '' : 's' }} right now
            </p>
            <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight leading-[1.05] max-w-3xl">
                Find work that fits.<br>Hire people who do.
            </h1>
            <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 max-w-xl">
                A straightforward job board. Employers post roles, applicants apply directly — no noise, no middlemen.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('jobs.browse') }}" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">
                    Browse Jobs
                </a>
                @auth
                    @if (auth()->user()->isEmployer())
                        <a href="{{ route('jobs.create') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-700 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-800">
                            Post a Job
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-700 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-800">
                        Post a Job
                    </a>
                @endauth
            </div>
        </section>

        <!-- Recently Posted -->
        <section class="border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-950/40">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <div class="flex items-baseline justify-between mb-8">
                    <h2 class="text-xl font-bold">Recently posted</h2>
                    <a href="{{ route('jobs.browse') }}" class="text-sm font-medium text-indigo-600 hover:underline">View all →</a>
                </div>

                @if ($recentJobs->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No open positions yet. Check back soon.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($recentJobs as $job)
                            <a href="{{ route('jobs.show', $job) }}" class="block p-5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg hover:border-indigo-300 dark:hover:border-indigo-700 transition">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $job->title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $job->company_name }} · {{ $job->location }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-3 uppercase tracking-wide">{{ str_replace('-', ' ', $job->job_type) }} · {{ $job->remote_option }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- Split -->
        <section class="max-w-6xl mx-auto px-6 py-16 grid grid-cols-1 sm:grid-cols-2 gap-12">
            <div>
                <h3 class="font-bold text-lg mb-2">For job seekers</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Filter by category, location, and job type. Apply directly, track every application's status in one place.
                </p>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-2">For employers</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Post a listing, review applicants, and manage decisions — accept or reject with one click.
                </p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-gray-100 dark:border-gray-800">
            <div class="max-w-6xl mx-auto px-6 py-8 text-sm text-gray-500 dark:text-gray-400">
                {{ config('app.name', 'JobBoard') }} — built with Laravel.
            </div>
        </footer>

    </body>
</html>