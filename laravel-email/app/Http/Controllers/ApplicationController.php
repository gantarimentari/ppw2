<?php

namespace App\Http\Controllers;
use App\Models\Application;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicationsExport;
use App\Exports\ApplicationsByJobExport;
// use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $jobId)
    {
        $applications = Application::with('user', 'job')->get();
        return view('applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);
        $cvPath = $request->file('cv')->store('cvs', 'public');
        Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
        ]);
        return back()->with('success', 'Lamaran berehasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function export()
    {
        return Excel::download(new ApplicationsExport, 'applications.xlsx');
    }

    /**
     * Export pelamar berdasarkan lowongan tertentu
     */
    public function exportByJob($jobId)
    {
        $job = \App\Models\JobVacancy::findOrFail($jobId);
        $fileName = 'pelamar_' . str_replace(' ', '_', strtolower($job->title)) . '_' . date('YmdHis') . '.xlsx';
        
        return Excel::download(new ApplicationsByJobExport($jobId), $fileName);
    }

    /**
     * Download CV pelamar
     */
    public function download($id)
    {
        $application = Application::findOrFail($id);
        $filePath = storage_path('app/public/' . $application->cv);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File CV tidak ditemukan');
        }
        
        return response()->download($filePath);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Update application status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return back()->with('success', 'Status lamaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
