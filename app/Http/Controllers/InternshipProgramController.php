<?php

namespace App\Http\Controllers;

use App\Models\InternshipProgram;
use App\Models\User;
use App\Models\InternshipApplications;
use Illuminate\Http\Request;

class InternshipProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = InternshipProgram::with('mentor')->latest()->paginate(10);
        return view('internship-programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentors = User::where('role', 'mentor')->get();
        return view('internship-programs.create', compact('mentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'mentor_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'max_participants' => 'required|integer|min:1',
            'requirements' => 'required|string',
            'benefits' => 'required|string',
            'status' => 'required|in:active,inactive,completed'
        ]);

        InternshipProgram::create($validated);

        return redirect()->route('internship-programs.index')
            ->with('success', 'Internship program created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InternshipProgram $internshipProgram)
    {
        $internshipProgram->load('mentor', 'applications');
        $programs = InternshipProgram::where('status', 'active')->get();
        return view('internship-programs.show', compact('internshipProgram', 'programs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InternshipProgram $internshipProgram)
    {
        $mentors = User::where('role', 'mentor')->get();
        return view('internship-programs.edit', compact('internshipProgram', 'mentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InternshipProgram $internshipProgram)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'mentor_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'max_participants' => 'required|integer|min:1',
            'requirements' => 'required|string',
            'benefits' => 'required|string',
            'status' => 'required|in:active,inactive,completed'
        ]);

        $internshipProgram->update($validated);

        return redirect()->route('internship-programs.index')
            ->with('success', 'Internship program updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InternshipProgram $internshipProgram)
    {
        $internshipProgram->delete();

        return redirect()->route('internship-programs.index')
            ->with('success', 'Internship program deleted successfully.');
    }

    /**
     * Handle internship program application
     */
    public function apply(Request $request)
    {
        // Validate user role
        if (auth()->user()->role !== 'magang') {
            return redirect()->route('landing')->with('error', 'Only internship students can apply.');
        }

        // Validate request
        $validated = $request->validate([
            'program_id' => 'required|exists:internship_programs,id',
            'resume' => 'required|file|mimes:pdf|max:2048'
        ]);

        try {
            $program = InternshipProgram::findOrFail($validated['program_id']);

            // Check if program is active
            if ($program->status !== 'active') {
                return redirect()->route('landing')->with('error', 'This program is not currently accepting applications.');
            }

            // Check if user has already applied
            if ($program->hasApplied(auth()->id())) {
                return redirect()->route('landing')->with('error', 'You have already applied for this program.');
            }

            // Store resume
            $resumePath = $request->file('resume')->store('resumes', 'public');

            // Create application
            InternshipApplications::create([
                'siswa_id' => auth()->id(),
                'program_id' => $program->id,
                'resume' => $resumePath,
                'status' => 'pending'
            ]);

            return redirect()->route('landing')
                ->with('success', 'Your application has been submitted successfully.');
        } catch (\Exception $e) {
            \Log::error('Application submission error: ' . $e->getMessage());
            return redirect()->route('landing')
                ->with('error', 'Failed to submit application. Please try again.');
        }
    }
}
