<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SemifinalPayment;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminSemifinalPaymentController extends Controller
{
    /**
     * Display a listing of semifinal payments.
     */
    public function index(Request $request)
    {
        $query = SemifinalPayment::with(['peserta', 'semifinalQualifier']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by competition category
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('semifinalQualifier', function ($q) use ($request) {
                $q->where('competition_category', $request->category);
            });
        }

        // Search by team name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('peserta', function ($q) use ($search) {
                $q->where('nama_tim', 'like', "%{$search}%");
            });
        }

        $payments = $query->latest()->paginate(20);

        // Statistics
        $statistics = [
            'total' => SemifinalPayment::count(),
            'pending' => SemifinalPayment::where('status', 'pending')->count(),
            'verified' => SemifinalPayment::where('status', 'verified')->count(),
            'rejected' => SemifinalPayment::where('status', 'rejected')->count(),
        ];

        return view('admin.semifinal-payments.index', compact('payments', 'statistics'));
    }

    /**
     * View payment proof file.
     */
    public function view(SemifinalPayment $payment)
    {
        $path = storage_path('app/public/' . $payment->payment_proof_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($path);
        
        return response()->file($path, [
            'Content-Type' => $mimeType,
        ]);
    }

    /**
     * Verify payment proof.
     */
    public function verify(SemifinalPayment $payment)
    {
        if ($payment->status === 'verified') {
            return redirect()->back()->with('error', 'Pembayaran sudah terverifikasi.');
        }

        $payment->update([
            'status' => 'verified',
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        // Create notification for the participant
        Notification::create([
            'user_id' => $payment->peserta->user_id,
            'type' => 'payment_verified',
            'title' => 'Pembayaran Semifinal Terverifikasi',
            'message' => 'Pembayaran semifinal Anda telah diverifikasi. Anda sekarang dapat mengupload submission semifinal.',
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /**
     * Reject payment proof.
     */
    public function reject(Request $request, SemifinalPayment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if ($payment->status === 'rejected') {
            return redirect()->back()->with('error', 'Pembayaran sudah ditolak sebelumnya.');
        }

        $payment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'verified_at' => null,
        ]);

        // Create notification for the participant
        Notification::create([
            'user_id' => $payment->peserta->user_id,
            'type' => 'payment_rejected',
            'title' => 'Pembayaran Semifinal Ditolak',
            'message' => 'Pembayaran semifinal Anda ditolak. Alasan: ' . $request->rejection_reason,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Pembayaran ditolak.');
    }
}
