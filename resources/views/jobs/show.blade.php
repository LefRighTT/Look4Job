<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $job->title }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ $job->company_name }} · {{ $job->location }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $job->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                        {{ ucfirst($job->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Job Type:</span>
                        <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($job->job_type) }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Remote Option:</span>
                        <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($job->remote_option) }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Category:</span>
                        <span class="text-gray-600 dark:text-gray-400">{{ $job->category->name }}</span>
                    </div>
                    @if ($job->salary)
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Salary:</span>
                            <span class="text-gray-600 dark:text-gray-400">${{ number_format($job->salary, 2) }}</span>
                        </div>
                    @endif
                    @if ($job->application_deadline)
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Deadline:</span>
                            <span class="text-gray-600 dark:text-gray-400">{{ $job->application_deadline->format('M d, Y') }}</span>
                        </div>
                    @endif
                </div>
                <div class="mb-6">
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Description</h4>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $job->description }}</p>
                </div>
                        @if (session('error'))
                            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                                {{ session('error') }}
                            </div>
                        @endif
                        @auth
                            @can('update', $job)
                                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('jobs.edit', $job) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Edit</a>
                                    <a href="{{ route('jobs.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">Back to My Jobs</a>
                                </div>
                            @endcan
                        @if (auth()->user()->isApplicant())
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    @if ($existingApplication)
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                            @if ($existingApplication->status === 'accepted') bg-green-100 text-green-800
                                            @elseif ($existingApplication->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                             Application {{ ucfirst($existingApplication->status) }}
                                 </span>
                             @else
                                  <a href="{{ route('applications.create', $job) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Apply for this Job</a>
                            @endif
                          </div>
                     @endif
                   @endauth
            </div>
        </div>
    </div>
</x-app-layout>