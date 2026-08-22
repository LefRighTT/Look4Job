<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Application Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $application->job->title }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ $application->job->company_name }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if ($application->status === 'accepted') bg-green-100 text-green-800
                        @elseif ($application->status === 'rejected') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>

                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Applicant</p>
                    <p class="text-gray-900 dark:text-white">{{ $application->user->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $application->user->email }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Applied {{ $application->created_at->format('M d, Y') }}</p>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Cover Letter</h4>
                    @if ($application->cover_letter)
                        <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $application->cover_letter }}</p>
                    @else
                        <p class="text-gray-400 dark:text-gray-500 italic">No cover letter submitted.</p>
                    @endif
                </div>

                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ auth()->user()->isEmployer() ? route('applications.manage') : route('applications.index') }}" class="text-sm text-indigo-600 hover:underline">
                        ← Back
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>