<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Applications') }}
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

                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">{{ count($applications) }} application(s) submitted</h3>

                @forelse ($applications as $application)
                    <div class="border-b border-gray-200 dark:border-gray-700 py-4 flex justify-between items-center">
                        <div>
                            <a href="{{ route('jobs.show', $application->job) }}" class="text-lg font-semibold text-indigo-600 hover:underline">
                                {{ $application->job->title }}
                            </a>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $application->job->company_name }} · Applied {{ $application->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if ($application->status === 'accepted') bg-green-100 text-green-800
                                @elseif ($application->status === 'rejected') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                            <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Withdraw this application?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">Withdraw</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">You haven't applied to any jobs yet. <a href="{{ route('jobs.browse') }}" class="text-indigo-600 hover:underline">Browse open positions</a>.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>