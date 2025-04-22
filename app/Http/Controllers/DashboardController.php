<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplications;
use App\Models\InternshipProgram;
use App\Models\InternshipTask;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Check user role and redirect non-mentor users
        if (auth()->user()->role !== 'mentor') {
            return redirect()->route('landing');
        }
        
        // Count data for summary cards
        $totalPrograms = InternshipProgram::count();
        $totalApplications = InternshipApplications::count();
        $acceptedApplications = InternshipApplications::where('status', 'accepted')->count();
        $pendingApplications = InternshipApplications::where('status', 'pending')->count();
        
        // Get recent applications
        $recentApplications = InternshipApplications::with(['siswa', 'program'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get active programs with application count
        $activePrograms = InternshipProgram::withCount('applications')
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();
        
        // Get recent tasks
        $recentTasks = InternshipTask::with(['application', 'application.siswa', 'application.program'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'totalPrograms', 
            'totalApplications', 
            'acceptedApplications', 
            'pendingApplications',
            'recentApplications',
            'activePrograms',
            'recentTasks'
        ));
    }
}
