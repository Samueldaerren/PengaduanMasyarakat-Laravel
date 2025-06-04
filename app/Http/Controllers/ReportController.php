<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Report;
use App\Models\Comment;

class ReportController extends Controller
{
    // Menampilkan halaman artikel (semua laporan)
    public function showArticle(Request $request)
    {
        $query = Report::orderBy('created_at', 'desc');

        if ($request->has('provinsi')) {
            $query->where('province', $request->input('provinsi'));
        }

        $reports = $query->get();

        return view('report.article', compact('reports'));
    }

    // Menampilkan halaman laporan pengguna yang sedang login
    public function showMe()
    {
        $reports = Report::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();
        return view('report.me', compact('reports'));
    }

    // Menampilkan halaman form pengaduan
    public function showCreateForm()
    {
        return view('report.create');
    }

    // Menangani pengaduan yang dibuat
    public function submitReport(Request $request)
    {
        // Validasi input pengaduan
        $validated = $request->validate([
            'description' => 'required',
            'type' => 'required|in:KEJAHATAN,PEMBANGUNAN,SOSIAL',
            'province' => 'required',
            'regency' => 'required',
            'subdistrict' => 'required',
            'village' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'statement' => 'required|boolean',
        ]);

        $imagePath = $this->handleImageUpload($request); // Handle image upload

        // Create report
        Report::create([
            'user_id' => Auth::id(),
            'description' => $validated['description'],
            'type' => $validated['type'],
            'province' => $validated['province'],
            'regency' => $validated['regency'],
            'subdistrict' => $validated['subdistrict'],
            'village' => $validated['village'],
            'viewers' => 0,
            'image' => $imagePath,
            'statement' => $validated['statement'],
            'voting' => json_encode([]),
            'votes' => 0 
        ]);

        return redirect()->route('report.me')->with('success', 'Pengaduan berhasil diajukan.');
    }

    // Dashboard with cached data
    public function showDashboard()
    {
        $complaintData = Cache::remember('dashboard_complaint_data', 60, function () {
            return Report::selectRaw('province, count(*) as complaints_count')
                ->groupBy('province')
                ->pluck('complaints_count', 'province')
                ->toArray();
        });

        $responseData = Cache::remember('dashboard_response_data', 60, function () {
            return Report::selectRaw('province, sum(statement) as responses_count')
                ->groupBy('province')
                ->pluck('responses_count', 'province')
                ->toArray();
        });

        return view('headstaff.dashboard', compact('complaintData', 'responseData'));
    }

    // Handle image upload
    private function handleImageUpload(Request $request)
    {
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('images', $filename, 'public');
            return 'storage/images/' . $filename;
        }
        return null;
    }

    // Show report details
    public function show($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Laporan tidak ditemukan.'], 404);
        }

        $report->increment('viewers');

        return view('report.show', compact('report'));
    }

    // Show report with comments
    public function showReport($id)
    {
        $report = Report::with('comments.user')->findOrFail($id);
        $hasResponse = $report->comments()->count() > 0;

        return view('report.show', compact('report', 'hasResponse'));
    }

    // Delete report
    public function delete($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('report.me')->with('success', 'Pengaduan berhasil dihapus.');
    }

    // Add comment to a report
    public function addComment(Request $request, $reportId)
    {
        $report = Report::findOrFail($reportId);

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Store comment
        Comment::create([
            'comment' => $request->comment,
            'user_id' => Auth::id(),
            'report_id' => $report->id,
        ]);

        return redirect()->route('report.show', $report->id);
    }

    // Update viewer count
    public function updateViewerCount($id)
    {
        $report = Report::findOrFail($id);
        $report->increment('viewers'); // Increment viewers count

        return response()->json([
            'viewers' => $report->viewers // Return updated viewer count
        ]);
    }

    // Toggle vote (add/remove)
    public function vote(Report $report)
    {
        $userId = auth()->id(); // Mendapatkan ID pengguna yang sedang login
        $voting = json_decode($report->voting, true); // Mengambil data voting (array)
    
        // Jika user sudah vote, kita unvote
        if (in_array($userId, $voting)) {
            // Hapus user dari array voting
            $voting = array_diff($voting, [$userId]);
        } else {
            // Tambahkan user ke dalam array voting
            $voting[] = $userId;
        }
    
        // Simpan kembali array voting sebagai JSON
        $report->voting = json_encode($voting);
        $report->votes = count($voting); // Update jumlah vote
        $report->save();
    
        // Redirect kembali dengan pesan sukses
        return redirect()->route('report.article', $report->id)->with('success', 'Voting berhasil diperbarui.');
    }

    // Menangani fitur pencarian berdasarkan provinsi
    public function search(Request $request)
{
    $query = Report::query();

    if ($request->has('provinsi')) {
        $query->where('provinsi', $request->input('provinsi'));
    }

    // Optional: Add more conditions if needed

    $reports = $query->get();

    if ($reports->isEmpty()) {
        return response()->json(['message' => 'No reports found for this provinsi'], 404);
    }

    return response()->json(['data' => $reports]);
}

}

