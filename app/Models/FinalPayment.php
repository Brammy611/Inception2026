<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalPayment extends Model
{
    use HasFactory;

    protected $table = 'final_payments';

    const STATUS_PENDING = 'pending';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'peserta_id',
        'final_qualifier_id',
        'payment_proof_path',
        'original_filename',
        'file_size',
        'status',
        'rejection_reason',
        'uploaded_at',
        'verified_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
        'file_size' => 'integer',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function finalQualifier()
    {
        return $this->belongsTo(FinalQualifier::class);
    }

    public function isVerified(): bool
    {
        return $this->status === self::STATUS_VERIFIED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($index = 0; $bytes > 1024; $index++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$index];
    }
}
