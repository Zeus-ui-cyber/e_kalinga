<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'student_id',
        'course',
        'year_level',
        'contact_number',
        'email',
        'concern',
        'preferred_date',
        'preferred_time',
        'urgency_level',
        'status',
        'privacy_agreed',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'privacy_agreed' => 'boolean',
    ];

    /* ── Relationships ── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->hasOne(AppointmentSchedule::class);
    }

    public function notifications()
    {
        return $this->hasMany(AppointmentNotification::class);
    }

    /* ── Scopes ── */

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOfStatus($query, $status)
    {
        return $status && $status !== 'all'
            ? $query->where('status', $status)
            : $query;
    }

    public function scopeUrgentFirst($query)
    {
        return $query->orderByRaw("FIELD(urgency_level, 'urgent', 'moderate', 'low')")
                     ->latest();
    }

    /* ── Helpers ── */

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'             => 'Pending',
            'processing'          => 'Processing',
            'confirmed'           => 'Confirmed',
            'interview_scheduled' => 'Interview Scheduled',
            'completed'           => 'Completed',
            'cancelled'           => 'Cancelled',
            default               => ucfirst($this->status),
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match($this->status) {
            'pending'             => 'status-pending',
            'processing'          => 'status-processing',
            'confirmed'           => 'status-confirmed',
            'interview_scheduled' => 'status-scheduled',
            'completed'           => 'status-completed',
            'cancelled'           => 'status-cancelled',
            default               => 'status-pending',
        };
    }

    public function getUrgencyIconAttribute(): string
    {
        return match($this->urgency_level) {
            'urgent'   => '🔴',
            'moderate' => '🟡',
            default    => '🟢',
        };
    }
}