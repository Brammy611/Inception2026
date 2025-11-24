<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerTalkRegistration;
use App\Mail\CareerTalkConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminCareerTalkController extends Controller
{
    /**
     * Display a listing of registrations
     */
    public function index(Request $request)
    {
        $query = CareerTalkRegistration::query();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $registrations = $query->paginate(20);

        // Statistics
        $stats = [
            'total' => CareerTalkRegistration::count(),
            'pending' => CareerTalkRegistration::where('status', 'pending')->count(),
            'confirmed' => CareerTalkRegistration::where('status', 'confirmed')->count(),
            'attended' => CareerTalkRegistration::where('status', 'attended')->count(),
            'cancelled' => CareerTalkRegistration::where('status', 'cancelled')->count(),
        ];

        return view('admin.career-talk.index', compact('registrations', 'stats'));
    }

    /**
     * Display the specified registration
     */
    public function show(CareerTalkRegistration $registration)
    {
        return view('admin.career-talk.show', compact('registration'));
    }

    /**
     * Update registration status
     */
    public function updateStatus(Request $request, CareerTalkRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,attended,cancelled'
        ]);

        $oldStatus = $registration->status;
        
        switch ($request->status) {
            case 'confirmed':
                $registration->markAsConfirmed();
                break;
            case 'attended':
                $registration->markAsAttended();
                break;
            case 'cancelled':
                $registration->markAsCancelled();
                break;
            default:
                $registration->update(['status' => $request->status]);
        }

        // Send email notification if status changed to confirmed
        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            try {
                Mail::to($registration->email)->send(
                    new CareerTalkConfirmationMail($registration)
                );
            } catch (\Exception $e) {
                Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }

    /**
     * Delete registration
     */
    public function destroy(CareerTalkRegistration $registration)
    {
        $registration->delete();
        return redirect()->route('admin.career-talk.index')
            ->with('success', 'Registrasi berhasil dihapus');
    }

    /**
     * Export to Excel
     */
    public function export(Request $request)
    {
        $query = CareerTalkRegistration::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        $filename = 'career-talk-registrations-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'No. Registrasi',
                'Nama Lengkap',
                'Email',
                'WhatsApp',
                'Institusi',
                'Program Studi',
                'Semester',
                'Status',
                'Tanggal Daftar',
                'Tanggal Konfirmasi',
                'Tanggal Hadir'
            ]);

            // Data
            foreach ($registrations as $reg) {
                fputcsv($file, [
                    $reg->registration_number,
                    $reg->full_name,
                    $reg->email,
                    $reg->phone,
                    $reg->institution,
                    $reg->major,
                    'Semester ' . $reg->semester,
                    ucfirst($reg->status),
                    $reg->created_at->format('d/m/Y H:i'),
                    $reg->confirmed_at ? $reg->confirmed_at->format('d/m/Y H:i') : '-',
                    $reg->attended_at ? $reg->attended_at->format('d/m/Y H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Check-in participant
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string'
        ]);

        $registration = CareerTalkRegistration::where('registration_number', $request->registration_number)
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor registrasi tidak ditemukan'
            ], 404);
        }

        if ($registration->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi telah dibatalkan'
            ], 400);
        }

        if ($registration->status === 'attended') {
            return response()->json([
                'success' => false,
                'message' => 'Peserta sudah melakukan check-in',
                'participant' => [
                    'name' => $registration->full_name,
                    'institution' => $registration->institution,
                    'checked_in_at' => $registration->attended_at->format('d/m/Y H:i')
                ]
            ], 400);
        }

        $registration->markAsAttended();

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'participant' => [
                'registration_number' => $registration->registration_number,
                'name' => $registration->full_name,
                'email' => $registration->email,
                'institution' => $registration->institution,
                'major' => $registration->major,
                'checked_in_at' => $registration->attended_at->format('d/m/Y H:i')
            ]
        ]);
    }

    /**
     * Send bulk confirmation emails
     */
    public function sendBulkConfirmation(Request $request)
    {
        $registrationIds = $request->input('registration_ids', []);
        
        $registrations = CareerTalkRegistration::whereIn('id', $registrationIds)->get();
        
        $sent = 0;
        $failed = 0;

        foreach ($registrations as $registration) {
            try {
                Mail::to($registration->email)->send(
                    new CareerTalkConfirmationMail($registration)
                );
                $registration->update(['email_sent' => true]);
                $sent++;
            } catch (\Exception $e) {
                Log::error('Failed to send email to ' . $registration->email . ': ' . $e->getMessage());
                $failed++;
            }
        }

        return redirect()->back()->with('success', "Email terkirim: {$sent}, Gagal: {$failed}");
    }
}