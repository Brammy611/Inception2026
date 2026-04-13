<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    /**
     * Filter requirements based on active stages.
     *
     * @param array $requirements
     * @return array
     */
    protected function filterActiveRequirements(array $requirements): array
    {
        $activeStages = config('submissions.active_stages', ['preliminary']);
        
        return array_filter($requirements, function ($requirement) use ($activeStages) {
            return in_array($requirement['stage'], $activeStages);
        });
    }
    /**
     * Display submission page with all requirements.
     */
    public function index()
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.register');
        }

        // Get submission requirements for this category
        $submissionConfig = config("submissions.categories.{$peserta->kategori}");
        
        if (!$submissionConfig) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Kategori lomba tidak ditemukan.');
        }

        // Filter requirements by active stages
        $submissionConfig['requirements'] = $this->filterActiveRequirements(
            $submissionConfig['requirements'] ?? []
        );

        // Get existing submissions
        $existingSubmissions = $peserta->submissions()
            ->get()
            ->keyBy(function ($item) {
                return $item->submission_type . '_' . $item->stage;
            });

        // Get competition info
        $competition = config("competitions.categories.{$peserta->kategori}");
        
        // Get semifinal information
        $semifinalQualifier = $peserta->semifinalQualifier;
        
        // Get active stages for view
        $activeStages = config('submissions.active_stages', ['preliminary']);

        return view('peserta.submissions', compact(
            'peserta',
            'submissionConfig',
            'existingSubmissions',
            'competition',
            'activeStages',
            'semifinalQualifier'
        ));
    }

    /**
     * Upload a submission file.
     */
    public function upload(Request $request)
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta tidak ditemukan.'
            ], 404);
        }

        // Check if peserta is verified
        if (!$peserta->isVerified()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus terverifikasi terlebih dahulu sebelum dapat mengunggah submission.'
            ], 403);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'submission_type' => 'required|string',
            'stage' => 'required|string',
            'file' => 'required|file|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $submissionType = $request->input('submission_type');
        $stage = $request->input('stage');

        // Check if stage is semifinal and verify payment
        if ($stage === 'semifinal') {
            if (!$peserta->isQualifiedForSemifinal()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tim Anda tidak lolos ke babak semifinal.'
                ], 403);
            }

            if (!$peserta->hasSemifinalPaymentVerified()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus mengupload dan memverifikasi bukti pembayaran semifinal terlebih dahulu.'
                ], 403);
            }
        }

        if ($stage === 'final') {
            if (!$peserta->isQualifiedForFinal()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tim Anda tidak lolos ke babak final.'
                ], 403);
            }

            if (!$peserta->hasFinalPaymentVerified()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus mengupload dan memverifikasi bukti pembayaran final terlebih dahulu.'
                ], 403);
            }
        }

        // Check if stage is active
        $activeStages = config('submissions.active_stages', ['preliminary']);
        if (!in_array($stage, $activeStages)) {
            return response()->json([
                'success' => false,
                'message' => 'Tahap kompetisi ini belum dibuka.'
            ], 422);
        }

        // Verify this submission type is valid for the category
        $requirements = config("submissions.categories.{$peserta->kategori}.requirements", []);
        $requirement = collect($requirements)->first(function ($req) use ($submissionType, $stage) {
            return $req['type'] === $submissionType && $req['stage'] === $stage;
        });

        if (!$requirement) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis submission tidak valid untuk kategori lomba Anda.'
            ], 422);
        }

        // Validate file size
        $maxSize = ($requirement['max_size'] ?? config('submissions.settings.default_max_size')) * 1024; // Convert to KB
        $file = $request->file('file');
        
        if ($file->getSize() > $maxSize * 1024) {
            return response()->json([
                'success' => false,
                'message' => "Ukuran file melebihi batas maksimum {$requirement['max_size']} MB."
            ], 422);
        }

        // Generate file path
        $storagePath = config('submissions.settings.storage_path');
        $categoryFolder = $peserta->kategori;
        $teamFolder = Str::slug($peserta->nama_tim);
        
        $filename = sprintf(
            '%s_%s_%s_%s.pdf',
            $teamFolder,
            $submissionType,
            $stage,
            now()->format('Ymd_His')
        );

        $fullPath = "{$storagePath}/{$categoryFolder}/{$teamFolder}";

        // Check for existing submission
        $existingSubmission = $peserta->getSubmission($submissionType, $stage);

        try {
            // Delete old file if exists
            if ($existingSubmission && $existingSubmission->file_path) {
                Storage::disk('public')->delete($existingSubmission->file_path);
            }

            // Store new file
            $filePath = $file->storeAs($fullPath, $filename, 'public');

            // Update or create submission record
            $submission = Submission::updateOrCreate(
                [
                    'peserta_id' => $peserta->id,
                    'submission_type' => $submissionType,
                    'stage' => $stage,
                ],
                [
                    'file_path' => $filePath,
                    'original_filename' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'uploaded_at' => now(),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diunggah!',
                'data' => [
                    'id' => $submission->id,
                    'file_path' => $filePath,
                    'original_filename' => $submission->original_filename,
                    'file_size' => $submission->formatted_file_size,
                    'uploaded_at' => $submission->uploaded_at->format('d M Y, H:i'),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengunggah file. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Delete a submission file.
     */
    public function delete(Request $request)
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta tidak ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'submission_type' => 'required|string',
            'stage' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $submission = $peserta->getSubmission(
            $request->input('submission_type'),
            $request->input('stage')
        );

        if (!$submission) {
            return response()->json([
                'success' => false,
                'message' => 'Submission tidak ditemukan.'
            ], 404);
        }

        try {
            // Delete file from storage
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }

            // Delete record
            $submission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Submission berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus file.'
            ], 500);
        }
    }

    /**
     * View a submission file.
     */
    public function view(string $type, string $stage)
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            abort(404);
        }

        $submission = $peserta->getSubmission($type, $stage);

        if (!$submission || !$submission->file_path) {
            abort(404);
        }

        $path = Storage::disk('public')->path($submission->file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $submission->original_filename . '"'
        ]);
    }

    /**
     * Download a submission file.
     */
    public function download(string $type, string $stage)
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            abort(404);
        }

        $submission = $peserta->getSubmission($type, $stage);

        if (!$submission || !$submission->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $submission->file_path,
            $submission->original_filename
        );
    }

    /**
     * Get submission status via AJAX.
     */
    public function status()
    {
        $user = auth()->user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta tidak ditemukan.'
            ], 404);
        }

        $requirements = config("submissions.categories.{$peserta->kategori}.requirements", []);
        
        // Filter by active stages
        $requirements = $this->filterActiveRequirements($requirements);
        
        $submissions = $peserta->submissions()->get();

        $status = [];
        foreach ($requirements as $requirement) {
            $submission = $submissions->first(function ($sub) use ($requirement) {
                return $sub->submission_type === $requirement['type'] 
                    && $sub->stage === $requirement['stage'];
            });

            $key = $requirement['type'] . '_' . $requirement['stage'];
            $status[$key] = [
                'uploaded' => $submission !== null,
                'file_size' => $submission ? $submission->formatted_file_size : null,
                'original_filename' => $submission ? $submission->original_filename : null,
                'uploaded_at' => $submission ? $submission->uploaded_at->format('d M Y, H:i') : null,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $status,
            'progress' => $peserta->submission_progress,
        ]);
    }
}
