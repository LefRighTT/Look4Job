<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @forelse ($applications as $jobId => $group)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            {{ $group->first()->job->title }}
                        </h3>

                        @foreach ($group as $application)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-800" data-application-id="{{ $application->id }}">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $application->user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $application->user->email }} · Applied {{ $application->created_at->format('M d, Y') }}</p>
                                    @if ($application->cover_letter)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 max-w-xl">{{ Str::limit($application->cover_letter, 150) }}</p>
                                    @endif
                                    <a href="{{ route('applications.show', $application) }}" class="text-sm text-indigo-600 hover:underline">View full application →</a>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="status-badge px-3 py-1 rounded-full text-sm font-medium
                                        @if ($application->status === 'accepted') bg-green-100 text-green-800
                                        @elseif ($application->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                    <button class="accept-btn text-sm text-green-600 hover:underline" data-status="accepted">Accept</button>
                                    <button class="reject-btn text-sm text-red-600 hover:underline" data-status="rejected">Reject</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">No applications yet.</p>
                @endforelse

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.accept-btn, .reject-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const row = button.closest('[data-application-id]');
                    const applicationId = row.dataset.applicationId;
                    const status = button.dataset.status;

                    fetch(`/applications/${applicationId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ status: status }),
                    })
                        .then(function (response) {
                            if (!response.ok) throw new Error('Update failed');
                            return response.json();
                        })
                        .then(function (data) {
                            const badge = row.querySelector('.status-badge');
                            badge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                            badge.className = 'status-badge px-3 py-1 rounded-full text-sm font-medium ' +
                                (data.status === 'accepted' ? 'bg-green-100 text-green-800' :
                                 data.status === 'rejected' ? 'bg-red-100 text-red-800' :
                                 'bg-yellow-100 text-yellow-800');
                        })
                        .catch(function () {
                            alert('Something went wrong updating this application.');
                        });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>