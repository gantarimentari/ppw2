<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\JobsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\JobVacancy;
use App\Exports\JobTemplateExport;

class JobController extends Controller
{
    
    public function index()
    {
        $jobs = JobVacancy::latest()->get();
        
        // Jika admin, tampilkan halaman kelola jobs
        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.jobs', compact('jobs'));
        }
        
        // Jika user biasa, tampilkan daftar jobs
        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function show($id)
    {
        $job = JobVacancy::findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
        ]);

        JobVacancy::create($request->all());
        return redirect()->route('admin.jobs')->with('success', 'Lowongan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $job = JobVacancy::findOrFail($id);
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
        ]);

        $job = JobVacancy::findOrFail($id);
        $job->update($request->all());
        return redirect()->route('admin.jobs')->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $job = JobVacancy::findOrFail($id);
        $job->delete();
        return redirect()->route('admin.jobs')->with('success', 'Lowongan berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        Excel::import(new JobsImport, $request->file('file'));
        return back()->with('success', 'Data lowongan berhasil diimport');
    }

    public function downloadTemplate()
    {
        return Excel::download(new JobTemplateExport, 'template_import_lowongan.xlsx');
    }
}
