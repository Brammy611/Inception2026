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
     * Get the semifinal qualifier record for this peserta.
     */
    public function semifinalQualifier()
    {
        return $this->hasOne(SemifinalQualifier::class);
    }

    /**
     * Get the semifinal payment for this peserta.
     */
    public function semifinalPayment()
    {
        return $this->hasOne(SemifinalPayment::class);
    }

    /**
     * Get the final qualifier record for this peserta.
     */
    public function finalQualifier()
    {
        return $this->hasOne(FinalQualifier::class);
    }

    /**
     * Get the final payment for this peserta.
     */
    public function finalPayment()
    {
        return $this->hasOne(FinalPayment::class);
    }

    /**
     * Check if this team qualified for semifinals.
     */
    public function isQualifiedForSemifinal(): bool
    {
        return $this->semifinalQualifier()->exists();
    }

    /**
     * Check if this team has uploaded semifinal payment proof.
     */
    public function hasUploadedSemifinalPayment(): bool
    {
        return $this->semifinalPayment()->exists();
    }

    /**
     * Check if this team's semifinal payment has been verified.
     */
    public function hasSemifinalPaymentVerified(): bool
    {
        return $this->semifinalPayment()->where('status', 'verified')->exists();
    }

    /**
     * Check if this team can upload semifinal submissions.
     * Team must be qualified AND have verified payment.
     */
    public function canUploadSemifinalSubmission(): bool
    {
        return $this->isQualifiedForSemifinal() && $this->hasSemifinalPaymentVerified();
    }

    /**
     * Check if this team qualified for finals.
     */
    public function isQualifiedForFinal(): bool
    {
        return $this->finalQualifier()->exists();
    }

    /**
     * Check if this team has uploaded final payment proof.
     */
    public function hasUploadedFinalPayment(): bool
    {
        return $this->finalPayment()->exists();
    }

    /**
     * Check if this team's final payment has been verified.
     */
    public function hasFinalPaymentVerified(): bool
    {
        return $this->finalPayment()->where('status', 'verified')->exists();
    }

    /**
     * Check if this team can upload final submissions.
     * Team must be qualified AND have verified payment.
     */
    public function canUploadFinalSubmission(): bool
    {
        return $this->isQualifiedForFinal() && $this->hasFinalPaymentVerified();
    }

    /**
     * Get submission requirements based on kategori.
     * Optionally filter by active stages.
     *
     * @param bool $activeOnly Whether to return only active stage requirements
     * @return array
     */
    public function getSubmissionRequirements(bool $activeOnly = false): array
    {
        $requirements = config("submissions.categories.{$this->kategori}.requirements", []);
        
        if ($activeOnly) {
            $activeStages = config('submissions.active_stages', ['preliminary']);
            $requirements = array_filter($requirements, function ($requirement) use ($activeStages) {
                return in_array($requirement['stage'], $activeStages);
            });
        }
        
        return $requirements;
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
     * Only counts active stage requirements.
     *
     * @return array
     */
    public function getSubmissionProgressAttribute(): array
    {
        // Use active requirements only for progress calculation
        $requirements = $this->getSubmissionRequirements(true);
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
