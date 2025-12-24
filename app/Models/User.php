<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
        'nama',
        'email',
        'password',
        'role',
        'nama_tim',
        'kategori_lomba',
        'foto',
        'status_verifikasi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is peserta.
     */
    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }

    /**
     * Get kategori lomba display name.
     */
    public function getKategoriDisplayAttribute(): string
    {
        return config("competitions.categories.{$this->kategori_lomba}.name", 'Unknown');
    }

    /**
     * Get all kategori lomba options.
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
     * Check if user is verified.
     */
    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'verified';
    }

    /**
     * Check if user is pending verification.
     */
    public function isPending(): bool
    {
        return $this->status_verifikasi === 'pending';
    }
}
