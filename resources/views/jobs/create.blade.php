<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Post a Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('jobs.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Job Title')" />
                        <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" :value="old('title')" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" class="block mt-1 w-full" :value="old('location')" required />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="salary" :value="__('Salary (optional)')" />
                        <x-text-input id="salary" name="salary" type="number" step="0.01" class="block mt-1 w-full" :value="old('salary')" />
                        <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="job_type" :value="__('Job Type')" />
                            <select id="job_type" name="job_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                                @foreach (['full-time', 'part-time', 'contract', 'internship'] as $type)
                                    <option value="{{ $type }}" {{ old('job_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('job_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="remote_option" :value="__('Remote Option')" />
                            <select id="remote_option" name="remote_option" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                                @foreach (['all options', 'remote', 'on-site', 'hybrid'] as $option)
                                    <option value="{{ $option }}" {{ old('remote_option') == $option ? 'selected' : '' }}>{{ ucfirst($option) }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('remote_option')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="company_name" :value="__('Company Name')" />
                        <x-text-input id="company_name" name="company_name" type="text" class="block mt-1 w-full" :value="old('company_name')" required />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="application_deadline" :value="__('Application Deadline (optional)')" />
                        <x-text-input id="application_deadline" name="application_deadline" type="date" class="block mt-1 w-full" :value="old('application_deadline')" />
                        <x-input-error :messages="$errors->get('application_deadline')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Post Job') }}</x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>