<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Apply for') }} {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $job->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $job->company_name }} · {{ $job->location }}</p>
                </div>

                <form method="POST" action="{{ route('applications.store', $job) }}">
                    @csrf

                    <div class="mb-6">
                        <x-input-label for="cover_letter" :value="__('Cover Letter (optional)')" />
                        <textarea id="cover_letter" name="cover_letter" rows="8" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" placeholder="Tell the employer why you're a good fit...">{{ old('cover_letter') }}</textarea>
                        <x-input-error :messages="$errors->get('cover_letter')" class="mt-2" />
                    </div>

                    <div class="flex gap-3">
                        <x-primary-button>{{ __('Submit Application') }}</x-primary-button>
                        <a href="{{ route('jobs.show', $job) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                            {{ __('Cancel') }}
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>