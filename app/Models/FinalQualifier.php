<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalQualifier extends Model
{
    use HasFactory;

    protected $table = 'final_qualifiers';

    protected $fillable = [
        'peserta_id',
        'competition_category',
        'team_name',
        'qualified_at',
    ];

    protected $casts = [
        'qualified_at' => 'datetime',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function finalPayment()
    {
        return $this->hasOne(FinalPayment::class);
    }

    public function hasUploadedPayment(): bool
    {
        return $this->finalPayment()->exists();
    }

    public function hasVerifiedPayment(): bool
    {
        return $this->finalPayment()->where('status', 'verified')->exists();
    }

    public function getCategoryDisplayAttribute(): string
    {
        return config("competitions.categories.{$this->competition_category}.name", 'Unknown');
    }
}
