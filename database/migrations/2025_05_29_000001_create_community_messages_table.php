<?php

// ============================================================
// FILE 1 — app/Models/CommunityMessage.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'body',
        'is_anonymous',
        'read_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'read_at'      => 'datetime',
    ];

    /**
     * The user who sent this message.
     * Returns null when the message is anonymous (sender_id is still stored
     * in the DB for moderation, but the view hides it when is_anonymous = true).
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}


// ============================================================
// FILE 2 — database/migrations/xxxx_xx_xx_create_community_messages_table.php
//
// Rename this file with today's timestamp, e.g.:
//   2025_05_29_000001_create_community_messages_table.php
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_messages', function (Blueprint $table) {
            $table->id();

            // The real sender is always stored for moderation purposes.
            // The is_anonymous flag controls visibility in the UI.
            $table->foreignId('sender_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->text('body');
            $table->boolean('is_anonymous')->default(false);

            // Nullable — set when any other member loads the page after this message was created.
            // For a community space this is a simple "seen by community" flag.
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_messages');
    }
};


// ============================================================
// FILE 3 — Add last_seen_at to users table (if not already present)
//
// Run:  php artisan make:migration add_last_seen_at_to_users_table --table=users
// Then paste the body below.
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tracks when a user was last active (used for the online strip)
            $table->timestamp('last_seen_at')->nullable()->after('remember_token');

            // True for peer facilitators / admins
            $table->boolean('is_facilitator')->default(false)->after('last_seen_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_seen_at', 'is_facilitator']);
        });
    }
};