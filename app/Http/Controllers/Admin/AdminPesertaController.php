<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::with('user');

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_tim', 'like', "%{$search}%")
                  ->orWhere('nama_leader', 'like', "%{$search}%")
                  ->orWhere('asal_univ', 'like', "%{$search}%");
            });
        }

        $peserta = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'total' => Peserta::count(),
            'verified' => Peserta::where('status_verifikasi', 'verified')->count(),
            'pending' => Peserta::where('status_verifikasi', 'pending')->count(),
            'rejected' => Peserta::where('status_verifikasi', 'rejected')->count(),
            'business_case' => Peserta::where('kategori', 'business_case')->count(),
            'geothermal' => Peserta::where('kategori', 'geothermal')->count(),
            'poster_paper' => Peserta::where('kategori', 'poster_paper')->count(),
            'well_stimulation' => Peserta::where('kategori', 'well_stimulation')->count(),
        ];

        return view('admin.peserta.index', compact('peserta', 'stats'));
    }

    public function show(Peserta $peserta)
    {
        $peserta->load('user');
        
        // Get competition details for styling
        $competitions = [
            'business_case' => ['name' => 'Business Case Competition', 'color' => '#FBB137'],
            'geothermal' => ['name' => 'Geothermal Drilling Paper Competition', 'color' => '#B22A2A'],
            'poster_paper' => ['name' => 'Petroleum Paper Competition', 'color' => '#4683B5'],
            'well_stimulation' => ['name' => 'Well Stimulation Competition', 'color' => '#32477C'],
        ];
        
        $competition = $competitions[$peserta->kategori_lomba] ?? ['name' => 'Competition', 'color' => '#FBB137'];

        return view('admin.peserta.show', compact('peserta', 'competition'));
    }

    public function updateStatus(Request $request, Peserta $peserta)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected'
        ]);

        $peserta->update([
            'status_verifikasi' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status peserta berhasil diupdate');
    }

    public function destroy(Peserta $peserta)
    {
        // Delete uploaded files
        if ($peserta->ktm) {
            Storage::disk('public')->delete($peserta->ktm);
        }
        if ($peserta->follow_ig) {
            Storage::disk('public')->delete($peserta->follow_ig);
        }
        if ($peserta->share_poster) {
            Storage::disk('public')->delete($peserta->share_poster);
        }
        if ($peserta->payment) {
            Storage::disk('public')->delete($peserta->payment);
        }

        // Delete user account
        $peserta->user->delete();

        // Delete peserta
        $peserta->delete();

        return redirect()->route('admin.peserta.index')->with('success', 'Peserta berhasil dihapus');
    }

    public function export(Request $request)
    {
        $query = Peserta::with('user');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        $peserta = $query->get();

        $filename = 'peserta_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($peserta) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'ID', 'Nama Tim', 'Kategori', 'Nama Leader', 'Email', 'Universitas', 
                'Jurusan Leader', 'Member 1', 'Jurusan Member 1', 'Member 2', 
                'Jurusan Member 2', 'Status', 'Tanggal Daftar'
            ]);

            // Data
            foreach ($peserta as $p) {
                fputcsv($file, [
                    $p->id,
                    $p->nama_tim,
                    ucfirst(str_replace('_', ' ', $p->kategori)),
                    $p->nama_leader,
                    $p->user->email ?? '-',
                    $p->asal_univ,
                    $p->jurusan_leader,
                    $p->nama_member_1 ?? '-',
                    $p->jurusan_member_1 ?? '-',
                    $p->nama_member_2 ?? '-',
                    $p->jurusan_member_2 ?? '-',
                    ucfirst($p->status_verifikasi),
                    $p->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * View KTM document
     */
    public function viewKtm($filename)
    {
        $path = storage_path('app/public/peserta/ktm/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path);
    }

    /**
     * View Follow IG document
     */
    public function viewFollowIg($filename)
    {
        $path = storage_path('app/public/peserta/follow_ig/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path);
    }

    /**
     * View Share Poster document
     */
    public function viewSharePoster($filename)
    {
        $path = storage_path('app/public/peserta/share_poster/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path);
    }

    /**
     * View Payment document
     */
    public function viewPayment($filename)
    {
        $path = storage_path('app/public/peserta/payment/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->file($path);
    }
}
