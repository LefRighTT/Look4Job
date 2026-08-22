<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Browse Jobs') }}
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

                <!-- Filter Bar -->
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
                    <select id="filter-category" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">All Categories</option>
                        @foreach (\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <select id="filter-job-type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">All Job Types</option>
                        <option value="full-time">Full-time</option>
                        <option value="part-time">Part-time</option>
                        <option value="contract">Contract</option>
                        <option value="internship">Internship</option>
                    </select>

                    <input id="filter-location" type="text" placeholder="Location" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">

                    <button id="filter-reset" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                        Reset
                    </button>
                </div>

                <h3 id="results-count" class="text-lg font-medium text-gray-900 dark:text-white mb-6">Loading...</h3>

                <div id="job-list">
                    <!-- populated by JS -->
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('filter-category');
            const jobTypeSelect = document.getElementById('filter-job-type');
            const locationInput = document.getElementById('filter-location');
            const resetButton = document.getElementById('filter-reset');
            const jobList = document.getElementById('job-list');
            const resultsCount = document.getElementById('results-count');

            function renderJobs(jobs) {
                resultsCount.textContent = jobs.length + ' open position(s)';

                if (jobs.length === 0) {
                    jobList.innerHTML = '<p class="text-gray-500 dark:text-gray-400">No jobs match your filters.</p>';
                    return;
                }

                jobList.innerHTML = jobs.map(function (job) {
                    const salary = job.salary ? '<p class="text-sm text-gray-500 dark:text-gray-400">$' + Number(job.salary).toLocaleString(undefined, {minimumFractionDigits: 2}) + '</p>' : '';
                    return `
                        <div class="border-b border-gray-200 dark:border-gray-700 py-4">
                            <a href="/jobs/${job.id}" class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">${job.title}</a>
                            <p class="text-sm text-gray-500 dark:text-gray-400">${job.company_name} · ${job.location} · ${job.job_type} · ${job.remote_option}</p>
                            ${salary}
                        </div>
                    `;
                }).join('');
            }

            function fetchJobs() {
                const params = new URLSearchParams();
                if (categorySelect.value) params.append('category_id', categorySelect.value);
                if (jobTypeSelect.value) params.append('job_type', jobTypeSelect.value);
                if (locationInput.value) params.append('location', locationInput.value);

                resultsCount.textContent = 'Loading...';

                fetch('/api/jobs?' + params.toString())
                    .then(function (response) { return response.json(); })
                    .then(renderJobs)
                    .catch(function () {
                        resultsCount.textContent = 'Something went wrong.';
                    });
            }

            let debounceTimer;
            function debouncedFetch() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(fetchJobs, 300);
            }

            categorySelect.addEventListener('change', fetchJobs);
            jobTypeSelect.addEventListener('change', fetchJobs);
            locationInput.addEventListener('input', debouncedFetch);

            resetButton.addEventListener('click', function () {
                categorySelect.value = '';
                jobTypeSelect.value = '';
                locationInput.value = '';
                fetchJobs();
            });

            fetchJobs();
        });
    </script>
    @endpush
</x-app-layout>