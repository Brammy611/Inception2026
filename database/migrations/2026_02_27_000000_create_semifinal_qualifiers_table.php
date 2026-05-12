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
        Schema::create('semifinal_qualifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->string('competition_category'); // business_case, geothermal, poster_paper, well_stimulation
            $table->string('team_name');
            $table->timestamp('qualified_at');
            $table->timestamps();

            // Ensure a team can only qualify once per competition category
            $table->unique(['peserta_id', 'competition_category'], 'unique_semifinalist');
            
            // Index for faster queries
            $table->index('competition_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semifinal_qualifiers');
    }
};
