<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplications;
use App\Models\InternshipTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InternshipTasksController extends Controller
{
    /**
     * Display a listing of the tasks for mentors
     */
    public function index(Request $request = null)
    {
        $query = InternshipTask::with(['application', 'application.siswa', 'application.program']);
        
        // Gunakan parameter request jika disediakan, jika tidak gunakan helper function request()
        $req = $request ?: request();
        
        // Search by task title or student name
        if ($req->filled('search')) {
            $searchTerm = $req->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('application.siswa', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // Filter by status
        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }
        
        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('internship-tasks.index', compact('tasks'));
    }

    /**
     * Display a listing of tasks for a specific intern
     */
    public function myTasks()
    {
        $tasks = InternshipTask::whereHas('application', function($query) {
                $query->where('siswa_id', auth()->id());
            })
            ->with(['application', 'application.program'])
            ->orderBy('deadline', 'asc')
            ->paginate(10);
        
        return view('internship-tasks.my-tasks', compact('tasks'));
    }

    /**
     * Show the form for creating a new task
     */
    public function create()
    {
        // Get all accepted applications
        $applications = InternshipApplications::where('status', 'accepted')
            ->with(['siswa', 'program'])
            ->get();
        
        return view('internship-tasks.create', compact('applications'));
    }

    /**
     * Store a newly created task
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:internship_applications,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
        ]);

        InternshipTask::create($validated);

        return redirect()->route('internship-tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task
     */
    public function show(InternshipTask $task)
    {
        $task->load(['application', 'application.siswa', 'application.program']);
        return view('internship-tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task
     */
    public function edit(InternshipTask $task)
    {
        $applications = InternshipApplications::where('status', 'accepted')
            ->with(['siswa', 'program'])
            ->get();
        
        return view('internship-tasks.edit', compact('task', 'applications'));
    }

    /**
     * Update the specified task
     */
    public function update(Request $request, InternshipTask $task)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:internship_applications,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,submitted,approved,rejected',
            'comments' => 'nullable|string',
        ]);

        $task->update($validated);

        return redirect()->route('internship-tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task
     */
    public function destroy(InternshipTask $task)
    {
        if ($task->report_file) {
            Storage::disk('public')->delete($task->report_file);
        }
        
        $task->delete();

        return redirect()->route('internship-tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Show the form for task submission
     */
    public function submitForm(InternshipTask $task)
    {
        // Check if the task belongs to the current user
        $task->load('application');
        
        if ($task->application->siswa_id !== auth()->id()) {
            return redirect()->route('internship-tasks.my-tasks')
                ->with('error', 'You are not authorized to submit this task.');
        }
        
        return view('internship-tasks.submit', compact('task'));
    }

    /**
     * Process task submission
     */
    public function submit(Request $request, InternshipTask $task)
    {
        // Check if the task belongs to the current user
        $task->load('application');
        
        if ($task->application->siswa_id !== auth()->id()) {
            return redirect()->route('internship-tasks.my-tasks')
                ->with('error', 'You are not authorized to submit this task.');
        }
        
        $validated = $request->validate([
            'report_file' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240',
        ]);

        // Delete old file if exists
        if ($task->report_file) {
            Storage::disk('public')->delete($task->report_file);
        }

        // Store new file
        $filePath = $request->file('report_file')->store('task_reports', 'public');
        
        $task->update([
            'report_file' => $filePath,
            'status' => 'submitted'
        ]);

        return redirect()->route('internship-tasks.my-tasks')
            ->with('success', 'Task submitted successfully.');
    }

    /**
     * Show the form for reviewing a task
     */
    public function reviewForm(InternshipTask $task)
    {
        $task->load(['application', 'application.siswa', 'application.program']);
        return view('internship-tasks.review', compact('task'));
    }

    /**
     * Process task review
     */
    public function review(Request $request, InternshipTask $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'comments' => 'required|string',
        ]);

        $task->update($validated);

        return redirect()->route('internship-tasks.index')
            ->with('success', 'Task reviewed successfully.');
    }

    /**
     * Download task report file
     */
    public function downloadReport(InternshipTask $task)
    {
        if (!$task->report_file || !Storage::disk('public')->exists($task->report_file)) {
            return redirect()->back()->with('error', 'Report file not found.');
        }

        return Storage::disk('public')->download($task->report_file);
    }
} 