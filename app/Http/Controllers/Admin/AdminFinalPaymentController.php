<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CompetitionPaymentStatusMail;
use App\Models\FinalPayment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminFinalPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = FinalPayment::with(['peserta', 'finalQualifier']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('finalQualifier', function ($builder) use ($request) {
                $builder->where('competition_category', $request->category);
            });
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('peserta', function ($builder) use ($search) {
                $builder->where('nama_tim', 'like', "%{$search}%");
            });
        }

        $payments = $query->latest()->paginate(20);

        $statistics = [
            'total' => FinalPayment::count(),
            'pending' => FinalPayment::where('status', 'pending')->count(),
            'verified' => FinalPayment::where('status', 'verified')->count(),
            'rejected' => FinalPayment::where('status', 'rejected')->count(),
        ];

        return view('admin.final-payments.index', compact('payments', 'statistics'));
    }

    public function view(FinalPayment $payment)
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

    public function verify(FinalPayment $payment)
    {
        $payment->loadMissing(['peserta.user', 'finalQualifier']);

        if ($payment->status === 'verified') {
            return redirect()->back()->with('error', 'Pembayaran final sudah terverifikasi.');
        }

        $payment->update([
            'status' => 'verified',
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        $category = $payment->finalQualifier->competition_category ?? $payment->peserta->kategori;
        $groupLink = $this->resolveGroupLink('final', $category);

        $notificationData = [
            'stage' => 'final',
        ];

        if (!empty($groupLink)) {
            $notificationData['whatsapp_link'] = $groupLink;
        }

        Notification::create([
            'user_id' => $payment->peserta->user_id,
            'type' => 'final_payment_verified',
            'title' => 'Pembayaran Final Terverifikasi',
            'message' => 'Pembayaran final Anda telah diverifikasi. Anda sekarang dapat mengupload submission final.',
            'data' => $notificationData,
            'is_read' => false,
        ]);

        $this->sendPaymentStatusMail(
            $payment,
            'final',
            'verified',
            $groupLink,
            null,
        );

        return redirect()->back()->with('success', 'Pembayaran final berhasil diverifikasi.');
    }

    public function reject(Request $request, FinalPayment $payment)
    {
        $payment->loadMissing(['peserta.user', 'finalQualifier']);

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if ($payment->status === 'rejected') {
            return redirect()->back()->with('error', 'Pembayaran final sudah ditolak sebelumnya.');
        }

        $payment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'verified_at' => null,
        ]);

        Notification::create([
            'user_id' => $payment->peserta->user_id,
            'type' => 'final_payment_rejected',
            'title' => 'Pembayaran Final Ditolak',
            'message' => 'Pembayaran final Anda ditolak. Alasan: ' . $request->rejection_reason,
            'is_read' => false,
        ]);

        $this->sendPaymentStatusMail(
            $payment,
            'final',
            'rejected',
            null,
            $request->rejection_reason,
        );

        return redirect()->back()->with('success', 'Pembayaran final ditolak.');
    }

    private function resolveGroupLink(string $stage, string $category): ?string
    {
        return config("competition_links.{$stage}.{$category}");
    }

    private function sendPaymentStatusMail(
        FinalPayment $payment,
        string $stage,
        string $status,
        ?string $groupLink,
        ?string $rejectionReason,
    ): void {
        try {
            $recipientEmail = $payment->peserta->user?->email;

            if (!$recipientEmail) {
                return;
            }

            Mail::to($recipientEmail)->send(
                new CompetitionPaymentStatusMail(
                    $payment->peserta,
                    $stage,
                    $status,
                    $groupLink,
                    $rejectionReason,
                )
            );
        } catch (\Throwable $exception) {
            Log::warning('Failed sending final payment status email', [
                'payment_id' => $payment->id,
                'status' => $status,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
