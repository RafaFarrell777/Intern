<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplications;
use App\Models\InternshipProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InternshipApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = InternshipApplications::with(['siswa', 'program'])->latest()->paginate(10);
        return view('application.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = InternshipProgram::where('status', 'active')->get();
        $students = User::where('role', 'magang')->get();
        return view('application.create', compact('programs', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:internship_programs,id',
            'resume' => 'required|file|mimes:pdf|max:2048',
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        InternshipApplications::create([
            'siswa_id' => $validated['siswa_id'],
            'program_id' => $validated['program_id'],
            'resume' => $resumePath,
            'status' => $validated['status']
        ]);

        return redirect()->route('application.index')
            ->with('success', 'Application created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InternshipApplications $application)
    {
        $application->load(['siswa', 'program']);
        return view('application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InternshipApplications $application)
    {
        $application->load(['siswa', 'program']);
        return view('application.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InternshipApplications $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $application->update($validated);

        return redirect()->route('application.index')
            ->with('success', 'Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InternshipApplications $application)
    {
        if ($application->resume) {
            Storage::disk('public')->delete($application->resume);
        }
        
        $application->delete();

        return redirect()->route('application.index')
            ->with('success', 'Application deleted successfully.');
    }

    /**
     * Download the resume file.
     */
    public function downloadResume(InternshipApplications $application)
    {
        if (!Storage::disk('public')->exists($application->resume)) {
            return redirect()->back()->with('error', 'Resume file not found.');
        }

        return Storage::disk('public')->download($application->resume);
    }
}
