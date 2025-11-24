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
        Schema::create('career_talk_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('institution');
            $table->string('major');
            $table->string('semester');
            $table->text('motivation');
            $table->enum('status', ['pending', 'confirmed', 'attended', 'cancelled'])->default('pending');
            $table->boolean('email_sent')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('attended_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('email');
            $table->index('registration_number');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_talk_registrations');
    }
};