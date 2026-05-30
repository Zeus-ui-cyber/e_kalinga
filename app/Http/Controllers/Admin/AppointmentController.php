<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentNotification;
use App\Models\AppointmentSchedule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Show all appointments with filters.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $query = Appointment::with(['user', 'schedule'])
            ->ofStatus($status)
            ->urgentFirst();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name',  'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('email',      'like', "%{$search}%")
                  ->orWhere('course',     'like', "%{$search}%");
            });
        }

        $appointments = $query->paginate(15);

        $stats = [
            'total'      => Appointment::count(),
            'pending'    => Appointment::where('status', 'pending')->count(),
            'processing' => Appointment::where('status', 'processing')->count(),
            'confirmed'  => Appointment::where('status', 'confirmed')->count(),
            'scheduled'  => Appointment::where('status', 'interview_scheduled')->count(),
            'completed'  => Appointment::where('status', 'completed')->count(),
            'cancelled'  => Appointment::where('status', 'cancelled')->count(),
            'urgent'     => Appointment::where('urgency_level', 'urgent')->count(),
        ];

        return view('appointments.admin.index', compact('appointments', 'stats', 'status'));
    }

    /**
     * Show a single appointment detail.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'schedule']);

        return view('appointments.admin.show', compact('appointment'));
    }

    /**
     * Update appointment status.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,confirmed,interview_scheduled,completed,cancelled',
        ]);

        $oldStatus = $appointment->status;
        $appointment->update(['status' => $request->status]);

        // Notify the student of status change
        AppointmentNotification::create([
            'user_id'        => $appointment->user_id,
            'appointment_id' => $appointment->id,
            'type'           => 'status_updated',
            'message'        => 'Your appointment request #' . $appointment->id
                . ' status has been updated to: '
                . $appointment->status_label . '.',
        ]);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'Status updated to ' . $appointment->status_label . '.');
    }

    /**
     * Show the set schedule form (GET).
     */
    public function scheduleForm(Appointment $appointment)
    {
        $appointment->load('schedule');
        return view('appointments.admin.show', compact('appointment'));
    }

    /**
     * Save or update interview schedule.
     */
    public function setSchedule(Request $request, Appointment $appointment)
    {
        $request->validate([
            'interview_date'  => 'required|date|after_or_equal:today',
            'interview_time'  => 'required|string|max:20',
            'meeting_details' => 'nullable|string|max:500',
            'counselor_notes' => 'nullable|string|max:2000',
        ]);

        // Create or update the schedule
        AppointmentSchedule::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'interview_date'  => $request->interview_date,
                'interview_time'  => $request->interview_time,
                'meeting_details' => $request->meeting_details,
                'counselor_notes' => $request->counselor_notes,
            ]
        );

        // Update appointment status to interview_scheduled
        $appointment->update(['status' => 'interview_scheduled']);

        // Notify student
        AppointmentNotification::create([
            'user_id'        => $appointment->user_id,
            'appointment_id' => $appointment->id,
            'type'           => 'interview_scheduled',
            'message'        => 'Your interview has been scheduled on '
                . \Carbon\Carbon::parse($request->interview_date)->format('F d, Y')
                . ' at ' . $request->interview_time . '.'
                . ($request->meeting_details ? ' Location/Details: ' . $request->meeting_details : ''),
        ]);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'Interview schedule has been set and the student has been notified.');
    }
}