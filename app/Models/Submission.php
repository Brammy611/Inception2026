<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'submissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'peserta_id',
        'submission_type',
        'stage',
        'file_path',
        'original_filename',
        'file_size',
        'uploaded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uploaded_at' => 'datetime',
        'file_size' => 'integer',
    ];

    /**
     * Get the peserta that owns the submission.
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    /**
     * Get the formatted file size.
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get the display name for the submission type.
     */
    public function getTypeDisplayNameAttribute(): string
    {
        $displayNames = config('submissions.type_display_names', []);
        return $displayNames[$this->submission_type] ?? ucfirst(str_replace('_', ' ', $this->submission_type));
    }

    /**
     * Get the display name for the stage.
     */
    public function getStageDisplayNameAttribute(): string
    {
        $stageNames = [
            'preliminary' => 'Preliminary Round',
            'semifinal' => 'Semifinal Round',
            'final' => 'Final Round',
            'general' => 'General',
        ];
        
        return $stageNames[$this->stage] ?? ucfirst($this->stage);
    }

    /**
     * Scope to filter by peserta.
     */
    public function scopeForPeserta($query, $pesertaId)
    {
        return $query->where('peserta_id', $pesertaId);
    }

    /**
     * Scope to filter by submission type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('submission_type', $type);
    }

    /**
     * Scope to filter by stage.
     */
    public function scopeInStage($query, $stage)
    {
        return $query->where('stage', $stage);
    }
}
