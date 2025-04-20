<?php

namespace App\Http\Controllers;

use App\Models\InternshipProgram;
use App\Models\User;
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
            'location' => 'required|string'
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
        return view('internship-programs.show', compact('internshipProgram'));
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
            'location' => 'required|string'
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
}
