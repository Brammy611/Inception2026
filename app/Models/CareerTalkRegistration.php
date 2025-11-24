<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerTalkRegistration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_number',
        'full_name',
        'email',
        'phone',
        'institution',
        'major',
        'semester',
        'motivation',
        'status',
        'email_sent',
        'confirmed_at',
        'attended_at',
    ];

    protected $casts = [
        'email_sent' => 'boolean',
        'confirmed_at' => 'datetime',
        'attended_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method to generate registration number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = self::generateRegistrationNumber();
            }
        });
    }

    /**
     * Generate unique registration number
     * Format: CT-YYYYMMDD-XXXX
     */
    public static function generateRegistrationNumber()
    {
        $date = now()->format('Ymd');
        $prefix = 'CT-' . $date . '-';
        
        // Try to generate unique number (max 10 attempts)
        $attempts = 0;
        $maxAttempts = 10;
        
        do {
            // Get the highest registration number for today
            $lastRegistration = self::where('registration_number', 'LIKE', $prefix . '%')
                ->orderBy('registration_number', 'desc')
                ->lockForUpdate()
                ->first();

            if ($lastRegistration) {
                // Extract number from last registration
                $lastNumber = (int) substr($lastRegistration->registration_number, -4);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $registrationNumber = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
            // Check if this number already exists
            $exists = self::where('registration_number', $registrationNumber)->exists();
            
            if (!$exists) {
                return $registrationNumber;
            }
            
            $attempts++;
            
            // If still exists, add random suffix to make it unique
            if ($attempts >= $maxAttempts) {
                $randomSuffix = strtoupper(substr(md5(microtime()), 0, 4));
                return $prefix . $randomSuffix;
            }
            
            // Small delay to avoid race condition
            usleep(100000); // 0.1 second
            
        } while ($attempts < $maxAttempts);
        
        // Fallback: use timestamp-based unique number
        return $prefix . strtoupper(substr(md5(microtime()), 0, 4));
    }

    /**
     * Scope untuk filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk pending registrations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk confirmed registrations
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope untuk attended registrations
     */
    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    /**
     * Check if registration is confirmed
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if participant has attended
     */
    public function hasAttended()
    {
        return $this->status === 'attended';
    }

    /**
     * Mark as confirmed
     */
    public function markAsConfirmed()
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    /**
     * Mark as attended
     */
    public function markAsAttended()
    {
        $this->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);
    }

    /**
     * Mark as cancelled
     */
    public function markAsCancelled()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Get full name attribute (accessor)
     */
    public function getFullNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}