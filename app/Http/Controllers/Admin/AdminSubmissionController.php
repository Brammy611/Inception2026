<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSubmissionController extends Controller
{
    /**
     * Display all submissions for a peserta.
     */
    public function index(Peserta $peserta)
    {
        $submissionConfig = config("submissions.categories.{$peserta->kategori}");
        
        if (!$submissionConfig) {
            return back()->with('error', 'Kategori lomba tidak ditemukan.');
        }

        $existingSubmissions = $peserta->submissions()
            ->get()
            ->keyBy(function ($item) {
                return $item->submission_type . '_' . $item->stage;
            });

        $competition = config("competitions.categories.{$peserta->kategori}");

        return view('admin.peserta.submissions', compact(
            'peserta',
            'submissionConfig',
            'existingSubmissions',
            'competition'
        ));
    }

    /**
     * View a specific submission file.
     */
    public function view(Peserta $peserta, string $type, string $stage)
    {
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
     * Download a specific submission file.
     */
    public function download(Peserta $peserta, string $type, string $stage)
    {
        $submission = $peserta->getSubmission($type, $stage);

        if (!$submission || !$submission->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $submission->file_path,
            $submission->original_filename
        );
    }
}
