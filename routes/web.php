<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    $recentJobs = \App\Models\Job::where('status', 'open')->latest()->take(6)->get();
    $openJobsCount = \App\Models\Job::where('status', 'open')->count();
    return view('welcome', compact('recentJobs', 'openJobsCount'));
});
Route::get('/dashboard', function () {
    return auth()->user()->isEmployer()
        ? redirect()->route('jobs.index')
        : redirect()->route('jobs.browse');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/browse-jobs', [JobController::class, 'browse'])->name('jobs.browse');
Route::get('/api/jobs', [JobController::class, 'filter'])->name('jobs.filter');
Route::middleware('auth')->group(function () {
    Route::resource('jobs', JobController::class);
    Route::get('/manage-applications', [ApplicationController::class, 'forEmployer'])->name('applications.manage');
    Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('/jobs/{job}/apply', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';