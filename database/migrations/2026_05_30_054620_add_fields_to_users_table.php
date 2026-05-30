<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // already included in add_student_fields_to_users_table migration
    }

    public function down(): void
    {
        // nothing to rollback
    }
};