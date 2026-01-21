<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'peserta';

    /**
     * Kategori Lomba Constants
     */
    const KATEGORI_BUSINESS_CASE = 'business_case';
    const KATEGORI_GEOTHERMAL = 'geothermal';
    const KATEGORI_POSTER_PAPER = 'poster_paper';
    const KATEGORI_WELL_STIMULATION = 'well_stimulation';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'nama_tim',
        'nama_leader',
        'asal_univ',
        'jurusan_leader',
        'nama_member_1',
        'jurusan_member_1',
        'nama_member_2',
        'jurusan_member_2',
        'nama_member_3',
        'jurusan_member_3',
        'kategori',
        'ktm',
        'follow_ig',
        'share_poster',
        'payment',
        'status_verifikasi',
    ];

    /**
     * Get the user that owns the peserta.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get kategori display name.
     */
    public function getKategoriDisplayAttribute(): string
    {
        return config("competitions.categories.{$this->kategori}.name", 'Unknown');
    }

    /**
     * Get all kategori options.
     */
    public static function getKategoriOptions(): array
    {
        return [
            self::KATEGORI_BUSINESS_CASE => 'Business Case Competition',
            self::KATEGORI_GEOTHERMAL => 'Geothermal Development Plan Competition',
            self::KATEGORI_POSTER_PAPER => 'Poster and Paper Competition',
            self::KATEGORI_WELL_STIMULATION => 'Well Stimulation Competition',
        ];
    }

    /**
     * Check if peserta is verified.
     */
    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'verified';
    }

    /**
     * Check if peserta is pending verification.
     */
    public function isPending(): bool
    {
        return $this->status_verifikasi === 'pending';
    }

    /**
     * Check if peserta is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status_verifikasi === 'rejected';
    }

    /**
     * Check if all required documents are uploaded.
     */
    public function hasAllDocuments(): bool
    {
        return $this->ktm && $this->follow_ig && $this->share_poster && $this->payment;
    }

    /**
     * Get team members as array.
     */
    public function getTeamMembersAttribute(): array
    {
        $members = [
            ['nama' => $this->nama_member_1, 'jurusan' => $this->jurusan_member_1],
        ];

        if ($this->nama_member_2) {
            $members[] = ['nama' => $this->nama_member_2, 'jurusan' => $this->jurusan_member_2];
        }

        return $members;
    }

    /**
     * Get all submissions for this peserta.
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get submission requirements based on kategori.
     */
    public function getSubmissionRequirements(): array
    {
        return config("submissions.categories.{$this->kategori}.requirements", []);
    }

    /**
     * Get a specific submission by type and stage.
     */
    public function getSubmission(string $type, string $stage): ?Submission
    {
        return $this->submissions()
            ->where('submission_type', $type)
            ->where('stage', $stage)
            ->first();
    }

    /**
     * Check if a specific submission exists.
     */
    public function hasSubmission(string $type, string $stage): bool
    {
        return $this->getSubmission($type, $stage) !== null;
    }

    /**
     * Get submission progress (percentage of uploaded files).
     */
    public function getSubmissionProgressAttribute(): array
    {
        $requirements = $this->getSubmissionRequirements();
        $totalRequired = 0;
        $totalUploaded = 0;

        foreach ($requirements as $requirement) {
            $totalRequired++;
            if ($this->hasSubmission($requirement['type'], $requirement['stage'])) {
                $totalUploaded++;
            }
        }

        return [
            'total' => $totalRequired,
            'uploaded' => $totalUploaded,
            'percentage' => $totalRequired > 0 ? round(($totalUploaded / $totalRequired) * 100) : 0,
        ];
    }
}
