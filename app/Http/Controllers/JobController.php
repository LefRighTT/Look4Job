<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->isEmployer()) {
            abort(403);
        }

        $jobs = Job::where('user_id', auth()->id())->latest()->get();

        return view('jobs.index', compact('jobs'));
    }
    public function create()
    {
        $this->authorize('create', Job::class);
        $categories = Category::all();
        return view('jobs.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $this->authorize('create', Job::class);

    $validated = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'location' => ['required', 'string', 'max:255'],
        'salary' => ['nullable', 'numeric'],
        'experience_level' => ['nullable', 'string', 'max:255'],
        'education_level' => ['nullable', 'string', 'max:255'],
        'skills' => ['nullable', 'string'],
        'benefits' => ['nullable', 'string'],
        'remote_option' => ['required', 'in:all options,remote,on-site,hybrid'],
        'job_type' => ['required', 'in:full-time,part-time,contract,internship'],
        'application_deadline' => ['nullable', 'date'],
        'company_name' => ['required', 'string', 'max:255'],
        'company_website' => ['nullable', 'url'],
    ]);

    $validated['user_id'] = auth()->id();
    $validated['status'] = 'open';

    Job::create($validated);

    return redirect()->route('jobs.index')->with('success', 'Job posted successfully.');
}

    /**
     * Display the specified resource.
     */
        public function show(Job $job)
    {
        $this->authorize('view', $job);
        $existingApplication = null;
        if (auth()->check() && auth()->user()->isApplicant()) {
            $existingApplication = \App\Models\Application::where('job_id', $job->id)
                ->where('user_id', auth()->id())
                ->first();
        }   
        return view('jobs.show', compact('job', 'existingApplication'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        $categories = Category::all();
        return view('jobs.edit', compact('job', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
    $this->authorize('update', $job);
    $validated = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'location' => ['required', 'string', 'max:255'],
        'salary' => ['nullable', 'numeric'],
        'experience_level' => ['nullable', 'string', 'max:255'],
        'education_level' => ['nullable', 'string', 'max:255'],
        'skills' => ['nullable', 'string'],
        'benefits' => ['nullable', 'string'],
        'remote_option' => ['required', 'in:all options,remote,on-site,hybrid'],
        'job_type' => ['required', 'in:full-time,part-time,contract,internship'],
        'application_deadline' => ['nullable', 'date'],
        'company_name' => ['required', 'string', 'max:255'],
        'company_website' => ['nullable', 'url'],
        'status' => ['required', 'in:open,closed'],
    ]);
    $job->update($validated);
    return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }
    public function browse()
    {
        $jobs = Job::where('status', 'open')->latest()->paginate(10);
        return view('jobs.browse', compact('jobs'));
    }
        public function filter(Request $request)
    {
        $query = Job::where('status', 'open');
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }
        $jobs = $query->latest()->get(['id', 'title', 'company_name', 'location', 'job_type', 'remote_option', 'salary']);
        return response()->json($jobs);
    }
}
