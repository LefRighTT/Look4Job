<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display the applicant's own applications.
     */
    public function index()
    {
        $applications = Application::where('user_id', auth()->id())
            ->with('job')
            ->latest()
            ->get();

        return view('applications.index', compact('applications'));
    }

    /**
     * Show the form for applying to a specific job.
     */
    public function create(Job $job)
    {
        $this->authorize('create', Application::class);

        return view('applications.create', compact('job'));
    }

    /**
     * Store a newly created application.
     */
        public function store(Request $request, Job $job)
    {
        $this->authorize('create', Application::class);

        $alreadyApplied = Application::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('jobs.show', $job)->with('error', 'You have already applied to this job.');
        }

        $validated = $request->validate([
            'cover_letter' => ['nullable', 'string'],
        ]);

        $validated['job_id'] = $job->id;
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        Application::create($validated);

        return redirect()->route('applications.index')->with('success', 'Application submitted.');
    }
    /**
     * Display the specified application.
     */
    public function show(Application $application)
    {
        $this->authorize('view', $application);

        return view('applications.show', compact('application'));
    }

    /**
     * Withdraw (delete) the specified application.
     */
    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);

        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Application withdrawn.');
    }
            public function forEmployer()
    {
        if (! auth()->user()->isEmployer()) {
            abort(403);
        }
        $applications = Application::whereHas('job', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->with(['job', 'user'])
            ->latest()
            ->get()
            ->groupBy('job_id');
        return view('applications.manage', compact('applications'));
    }
        public function updateStatus(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected'],
        ]);

        $application->update($validated);

        return response()->json(['status' => $application->status]);
    }
}