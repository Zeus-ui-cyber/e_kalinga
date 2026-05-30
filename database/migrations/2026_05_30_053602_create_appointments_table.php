<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Who made the request
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Form fields
            $table->string('full_name');
            $table->string('student_id')->nullable();
            $table->string('course')->nullable();
            $table->string('year_level')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('concern');                         // reason for consultation
            $table->date('preferred_date')->nullable();
            $table->string('preferred_time')->nullable();

            // Urgency: low | moderate | urgent
            $table->enum('urgency_level', ['low', 'moderate', 'urgent'])->default('low');

            // Status workflow
            $table->enum('status', [
                'pending',
                'processing',
                'confirmed',
                'interview_scheduled',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};