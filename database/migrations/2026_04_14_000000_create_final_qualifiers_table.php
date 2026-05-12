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
        Schema::create('final_qualifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->string('competition_category');
            $table->string('team_name');
            $table->timestamp('qualified_at');
            $table->timestamps();

            $table->unique(['peserta_id', 'competition_category'], 'unique_finalist');
            $table->index('competition_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_qualifiers');
    }
};
