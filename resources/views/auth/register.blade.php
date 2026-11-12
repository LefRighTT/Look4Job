<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight">Create your account</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Takes less than a minute.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5"
          x-data="{
              role: @js(old('role', 'employer')),
              show: false, loading: false, password: '', confirm: '',
              get strength() {
                  if (!this.password) return 0;
                  let s = 0;
                  if (this.password.length >= 8) s++;
                  if (/[a-z]/.test(this.password) && /[A-Z]/.test(this.password)) s++;
                  if (/\d/.test(this.password)) s++;
                  if (/[^A-Za-z0-9]/.test(this.password)) s++;
                  return Math.max(s, 1);
              },
              get label() { return ['', 'Weak', 'Fair', 'Good', 'Strong'][this.strength]; },
              get color() { return ['', 'bg-red-500', 'bg-amber-500', 'bg-lime-500', 'bg-green-500'][this.strength]; }
          }"
          @submit="loading = true">
        @csrf

        <!-- Role -->
        <div>
            <span class="block text-sm font-medium mb-1.5">I want to…</span>
            <div class="grid grid-cols-2 gap-3">
                <label class="cursor-pointer">
                    <input type="radio" name="role" value="employer" x-model="role" class="peer sr-only">
                    <div class="rounded-lg border border-gray-300 dark:border-gray-600 p-3 text-center transition hover:border-indigo-300
                                peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:ring-1 peer-checked:ring-indigo-600
                                dark:peer-checked:bg-indigo-900/30 peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-500">
                        <div class="text-sm font-semibold">Hire people</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Employer</div>
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="role" value="applicant" x-model="role" class="peer sr-only">
                    <div class="rounded-lg border border-gray-300 dark:border-gray-600 p-3 text-center transition hover:border-indigo-300
                                peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:ring-1 peer-checked:ring-indigo-600
                                dark:peer-checked:bg-indigo-900/30 peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-500">
                        <div class="text-sm font-semibold">Find work</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Applicant</div>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium mb-1.5">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="Juan Dela Cruz"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400 transition">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                   placeholder="you@example.com"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400 transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium mb-1.5">Password</label>
            <div class="relative">
                <input id="password" name="password" x-model="password" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                       placeholder="At least 8 characters"
                       class="w-full pr-11 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400 transition">
                <button type="button" @click="show = !show" :aria-label="show ? 'Hide password' : 'Show password'"
                        class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>

            <!-- Strength meter -->
            <div x-show="password" x-cloak class="mt-2">
                <div class="flex gap-1">
                    <template x-for="i in 4" :key="i">
                        <div class="h-1 flex-1 rounded-full transition-all duration-300"
                             :class="i <= strength ? color : 'bg-gray-200 dark:bg-gray-700'"></div>
                    </template>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" x-text="label"></p>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-1.5">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" x-model="confirm" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                   placeholder="Repeat your password"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400 transition">
            <p x-show="confirm" x-cloak class="mt-1 text-xs"
               :class="confirm === password ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'"
               x-text="confirm === password ? '✓ Passwords match' : 'Passwords don\'t match yet'"></p>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <button type="submit" :disabled="loading"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-indigo-600 text-white font-medium
                       hover:bg-indigo-700 active:scale-[.98] disabled:opacity-70 disabled:cursor-not-allowed transition">
            <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/><path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/></svg>
            <span x-text="loading ? 'Creating account…' : 'Create account'">Create account</span>
        </button>

        <p class="pt-2 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700">
            Already registered?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:underline">Log in</a>
        </p>
    </form>
</x-guest-layout>
