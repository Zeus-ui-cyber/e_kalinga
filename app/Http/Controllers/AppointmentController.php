<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Show all appointments for the logged-in student.
     */
    public function index()
    {
        $appointments = Appointment::with('schedule')
            ->forUser(Auth::id())
            ->latest()
            ->paginate(10);

        return view('student.index', compact('appointments'));
    }

    /**
     * Show the appointment request form.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a new appointment request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:191',
            'student_id'     => 'required|string|max:50',
            'course'         => 'required|string|max:100',
            'year_level'     => 'required|string|max:50',
            'contact_number' => 'required|string|max:30',
            'email'          => 'required|email|max:191',
            'concern'        => 'required|string|min:20|max:5000',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required|string|max:20',
            'urgency_level'  => 'required|in:low,moderate,urgent',
            'privacy_agreed' => 'required|accepted',
        ], [
            'concern.min'        => 'Please describe your concern in at least 20 characters.',
            'preferred_date.after' => 'Preferred date must be at least 1 day from today.',
            'privacy_agreed.required' => 'You must agree to the privacy policy.',
            'privacy_agreed.accepted' => 'You must agree to the privacy policy.',
        ]);

        $appointment = Appointment::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status'  => 'pending',
        ]);

        // Create a notification for the student
        AppointmentNotification::create([
            'user_id'        => Auth::id(),
            'appointment_id' => $appointment->id,
            'type'           => 'submitted',
            'message'        => 'Your appointment request #' . $appointment->id . ' has been submitted and is now pending review.',
        ]);

        // Notify all admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            AppointmentNotification::create([
                'user_id'        => $admin->id,
                'appointment_id' => $appointment->id,
                'type'           => 'new_request',
                'message'        => 'New appointment request from ' . $appointment->full_name . ' (' . $appointment->student_id . ').',
            ]);
        }

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Your appointment request has been submitted! We will contact you soon.');
    }

    /**
     * Show a single appointment for the student.
     */
    public function show(Appointment $appointment)
    {
        // Students can only view their own appointments
        abort_unless($appointment->user_id === Auth::id(), 403);

        $appointment->load('schedule');

        return view('student.show', compact('appointment'));
    }
}