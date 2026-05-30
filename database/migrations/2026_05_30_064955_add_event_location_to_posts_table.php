<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'event_date')) {
                $table->string('event_date', 255)->nullable()->after('type');
            }

            if (!Schema::hasColumn('posts', 'event_location')) {
                $table->string('event_location', 255)->nullable()->after('event_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'event_location')) {
                $table->dropColumn('event_location');
            }

            if (Schema::hasColumn('posts', 'event_date')) {
                $table->dropColumn('event_date');
            }
        });
    }
};