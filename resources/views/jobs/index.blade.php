<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Job Listings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ count($jobs) }} Job(s) posted</h3>
                    <a href="{{ route('jobs.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        + Post a Job
                    </a>
                </div>

                @forelse ($jobs as $job)
                    <div class="border-b border-gray-200 dark:border-gray-700 py-4 flex justify-between items-center">
                        <div>
                            <a href="{{ route('jobs.show', $job) }}" class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                                {{ $job->title }}
                            </a>
                            <p class="text-sm text-gray-500">{{ $job->location }} · {{ ucfirst($job->job_type) }} · {{ ucfirst($job->status) }}</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('jobs.edit', $job) }}" class="text-sm text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Delete this job listing?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">You haven't posted any jobs yet.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>