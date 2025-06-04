<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\ResponseProgress;
use App\Models\Response;

class StaffController extends Controller
{
    // Menampilkan daftar laporan dengan pengurutan berdasarkan jumlah suara
    public function index(Request $request)
    {
        // Mengambil parameter urutan dari request, default 'asc'
        $sortOrder = $request->get('sort_order', 'asc');

        // Mengambil data laporan dengan relasi user, dan mengurutkan berdasarkan 'votes'
        $reports = Report::with('user')
                     ->orderBy('votes', $sortOrder)  // Mengurutkan berdasarkan jumlah suara
                     ->get();
        
        // Mengirim data laporan ke view staff di folder dashboard
        return view('staff.dashboard', compact('reports'));
    }

    // Menampilkan detail laporan
    public function show($id)
    {
        // Mengambil data laporan berdasarkan ID yang diberikan, dengan relasi user
        $report = Report::findOrFail($id);

        // Mengirim data laporan ke view show
        return view('staff.show', compact('report'));
    }

    // Menyimpan tindak lanjut dari staff (Hanya menampilkan halaman untuk saat ini)
    public function processAction(Request $request)
    {
        // Mengambil report_id dari request
        $reportId = $request->input('report_id');
    
        // Redirect ke halaman show dengan ID laporan
        return redirect()->route('staff.show', ['id' => $reportId]);
    }
    
    // Menyimpan progress untuk response tertentu
    public function storeProgress(Request $request, Report $report)
    {
        // Validasi input
        $request->validate([
            'progress' => 'required|string|max:255',
            'response_id' => 'required|exists:responses,id', // Validasi response_id yang ada di tabel responses
        ]);

        // Menyimpan progress di tabel responseprogress
        ResponseProgress::create([
            'response_id' => $request->response_id, // Menggunakan response_id yang diterima dari request
            'histories' => json_encode([
                'progress' => $request->progress,
                'updated_at' => now(),
            ]),
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Progress added successfully!');
    }

    
}
