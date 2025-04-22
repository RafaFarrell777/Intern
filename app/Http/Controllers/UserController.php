<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InternshipApplications;
use App\Models\InternshipTask;
use App\Models\InternshipProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search by name or email
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->latest()->paginate(10);
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:mentor,magang'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:mentor,magang'
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting self
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }
        
        try {
            DB::beginTransaction();
            
            // Check if user is a student (magang) with applications
            if ($user->isMagang()) {
                // Get all applications of this user using the relationship
                $applications = $user->applications;
                
                foreach ($applications as $application) {
                    // Delete all tasks related to this application
                    $tasks = InternshipTask::where('application_id', $application->id)->get();
                    foreach ($tasks as $task) {
                        $task->delete();
                    }
                    
                    // Then delete the application
                    $application->delete();
                }
            }
            
            // Check if user is a mentor with programs
            if ($user->isMentor()) {
                // Get programs using the relationship
                $programs = $user->programs;
                
                if ($programs->count() > 0) {
                    // Find another mentor
                    $anotherMentor = User::where('role', 'mentor')
                        ->where('id', '!=', $user->id)
                        ->first();
                    
                    if ($anotherMentor) {
                        // Reassign programs to another mentor
                        foreach ($programs as $program) {
                            $program->mentor_id = $anotherMentor->id;
                            $program->save();
                        }
                    } else {
                        // No other mentor, mark programs as inactive
                        foreach ($programs as $program) {
                            $program->status = 'inactive';
                            $program->save();
                        }
                    }
                }
            }
            
            // Finally delete the user
            $user->delete();
            
            DB::commit();
            
            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully.');
                
        } catch (QueryException $e) {
            DB::rollBack();
            
            // Check if it's a foreign key constraint issue
            if ($e->getCode() == 23000) {
                return redirect()->route('users.index')
                    ->with('error', 'Cannot delete user. This user has related data that cannot be deleted automatically.');
            }
            
            return redirect()->route('users.index')
                ->with('error', 'An error occurred while deleting user: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('users.index')
                ->with('error', 'An error occurred while deleting user: ' . $e->getMessage());
        }
    }
}
