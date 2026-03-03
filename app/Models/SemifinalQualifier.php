<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemifinalQualifier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'semifinal_qualifiers';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'peserta_id',
        'competition_category',
        'team_name',
        'qualified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'qualified_at' => 'datetime',
    ];

    /**
     * Get the peserta that qualified.
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    /**
     * Get the semifinal payment for this qualifier.
     */
    public function semifinalPayment()
    {
        return $this->hasOne(SemifinalPayment::class);
    }

    /**
     * Check if payment has been uploaded.
     */
    public function hasUploadedPayment(): bool
    {
        return $this->semifinalPayment()->exists();
    }

    /**
     * Check if payment has been verified.
     */
    public function hasVerifiedPayment(): bool
    {
        return $this->semifinalPayment()->where('status', 'verified')->exists();
    }

    /**
     * Get the competition category display name.
     */
    public function getCategoryDisplayAttribute(): string
    {
        return config("competitions.categories.{$this->competition_category}.name", 'Unknown');
    }
}
