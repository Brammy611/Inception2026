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
        Schema::create('semifinal_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('semifinal_qualifier_id')->constrained('semifinal_qualifiers')->onDelete('cascade');
            $table->string('payment_proof_path');
            $table->string('original_filename');
            $table->bigInteger('file_size'); // in bytes
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('uploaded_at');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            // Ensure one payment proof per semifinalist
            $table->unique('semifinal_qualifier_id', 'unique_semifinal_payment');
            
            // Index for faster queries
            $table->index(['peserta_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semifinal_payments');
    }
};
