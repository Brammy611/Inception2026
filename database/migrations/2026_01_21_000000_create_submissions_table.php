<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->string('submission_type'); // e.g., 'abstract', 'full_paper', 'essay', etc.
            $table->string('stage'); // e.g., 'preliminary', 'semifinal', 'final'
            $table->string('file_path');
            $table->string('original_filename');
            $table->bigInteger('file_size'); // in bytes
            $table->timestamp('uploaded_at');
            $table->timestamps();

            // Composite unique key to ensure one file per type per stage per peserta
            $table->unique(['peserta_id', 'submission_type', 'stage'], 'unique_submission');
            
            // Index for faster queries
            $table->index(['peserta_id', 'submission_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
