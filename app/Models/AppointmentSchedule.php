<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSchedule extends Model
{
    protected $fillable = [
        'appointment_id',
        'interview_date',
        'interview_time',
        'meeting_details',
        'counselor_notes',
    ];

    protected $casts = [
        'interview_date' => 'date',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}