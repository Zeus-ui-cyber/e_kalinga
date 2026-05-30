<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('appointment_id')
                  ->unique()                      // one schedule per appointment
                  ->constrained()
                  ->onDelete('cascade');

            $table->date('interview_date');
            $table->string('interview_time', 20);
            $table->string('meeting_details')->nullable();   // location / link
            $table->text('counselor_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_schedules');
    }
};