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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_tim');
            $table->string('nama_leader');
            $table->string('asal_univ');
            $table->string('jurusan_leader');
            $table->string('nama_member_1');
            $table->string('jurusan_member_1');
            $table->string('nama_member_2')->nullable();
            $table->string('jurusan_member_2')->nullable();
            $table->enum('kategori', [
                'business_case',
                'geothermal',
                'poster_paper',
                'well_stimulation'
            ]);
            $table->string('ktm')->nullable(); // PDF file path
            $table->string('follow_ig')->nullable(); // PDF file path
            $table->string('share_poster')->nullable(); // PDF file path
            $table->string('payment')->nullable(); // PDF file path
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
