<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplications;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateInternshipApplicationsRequest;
use Illuminate\Http\Request;

class InternshipApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = InternshipApplications::with('siswa')->latest()->paginate(10);
        return view('application.table', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('application.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        if($req->hasFile('resume')) {
            $file = $req->file('resume');
            $mimeType = $file->getMimeType();
            $resume = date('Ymd') . '0' . Auth::id();

            if(Str::startsWith($mimeType, ['application/pdf', 'image', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'])) {
                $insertResume = InternshipApplications::create([
                    'siswa_id' => Auth::id(),
                    'status' => 'pending',
                    'resume' => $resume . '.' . $file->getClientOriginalExtension(),
                ]);
                $file->move(public_path('storage/assets'), $insertResume->resume);
                return redirect()->route('application.table')->with('success','Success add application!');
            }
            return false;
        }
        return false;
    }

    /**
     * Display the specified resource.
     */
    public function show(InternshipApplications $internshipApplications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $req, $id)
    {
        $application = InternshipApplications::with('siswa')->where('id', '=', $id)->first();
        if (!$application) {
            return redirect()->back()->with('error', 'Application not found.');
        }
        return view('application.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, $id)
    {
        if($req->hasFile('resume')) {
            $file = $req->file('resume');
            $mimeType = $file->getMimeType();
            $resume = date('Ymd') . '0' . Auth::id();

            $data = InternshipApplications::findOrFail($id);

            unlink('storage/assets/' . $data->resume);

            if(Str::startsWith($mimeType, ['application/pdf', 'image', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'])) {
                $updateResume = $data->update([
                    'resume' => $resume . '.' . $file->getClientOriginalExtension(),
                ]);
                if ($updateResume) {
                    $file->move(public_path('storage/assets'), $data->resume);
                    return redirect()->route('application.table')->with('success','Success add application!');
                } else {
                    return false;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $data = InternshipApplications::findOrFail($id);
        if($data->delete()) {
            return redirect()->route('application.table')->with('success','Success delete application!');
        }
    }
}
