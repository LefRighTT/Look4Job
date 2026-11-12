<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight">Welcome back</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Log in to manage your jobs and applications.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5"
          x-data="{ show: false, loading: false, email: @js(old('email', '')), password: '' }"
          @submit="loading = true">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
            <input id="email" name="email" type="email" x-model="email" required autofocus autocomplete="username"
                   placeholder="you@example.com"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100
                          focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400 transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-indigo-600 hover:underline">Forgot?</a>
                @endif
            </div>
            <div class="relative">
                <input id="password" name="password" x-model="password" :type="show ? 'text' : 'password'" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pr-11 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100
                              focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400 transition">
                <button type="button" @click="show = !show" :aria-label="show ? 'Hide password' : 'Show password'"
                        class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember -->
        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-indigo-600 focus:ring-indigo-500">
            <span class="text-sm text-gray-600 dark:text-gray-400">Remember me</span>
        </label>

        <!-- Submit -->
        <button type="submit" :disabled="loading"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-indigo-600 text-white font-medium
                       hover:bg-indigo-700 active:scale-[.98] disabled:opacity-70 disabled:cursor-not-allowed transition">
            <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/><path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/></svg>
            <span x-text="loading ? 'Logging in…' : 'Log in'">Log in</span>
        </button>

        <!-- Demo helper -->
        <button type="button" @click="email = 'employer@demo.com'; password = 'password'"
                class="w-full text-xs text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition">
            Just looking? <span class="underline">Fill demo employer</span>
        </button>

        <p class="pt-2 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:underline">Register</a>
        </p>
    </form>
</x-guest-layout>
