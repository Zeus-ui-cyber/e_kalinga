<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->studentDashboard($user);
    }

    private function adminDashboard()
    {
        $stats = [
            'total_students'       => User::where('role', 'student')->count(),
            'active_cases'         => 0,
            'pending_appointments' => 0,
            'unread_messages'      => Auth::user()->unreadMessagesCount(),
            'urgent_appointments'  => 0,
            'scheduled_today'      => 0,
            'total_appointments'   => 0,
        ];

        $recentStudents = User::where('role', 'student')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $trends = [
            ['label' => 'Academic stress', 'pct' => 45],
            ['label' => 'Family issues',   'pct' => 28],
            ['label' => 'Mental health',   'pct' => 19],
            ['label' => 'Other',           'pct' => 8],
        ];

        $pendingAppointments = collect();
        $upcomingInterviews  = collect();
        $adminNotifications  = collect();

        return view('dashboard.index', compact(
            'stats', 'recentStudents', 'trends',
            'pendingAppointments', 'upcomingInterviews',
            'adminNotifications'
        ));
    }

    private function studentDashboard(User $user)
    {
        $stats = [
            'sessions'            => 0,
            'messages_sent'       => 0,
            'total_appointments'  => 0,
            'pending_appointments'=> 0,
            'active_appointments' => 0,
        ];

        $feedPosts           = collect();
        $nextAppointment     = null;
        $latestAppointment   = null;
        $appointmentHistory  = collect();
        $myNotifications     = collect();

        return view('dashboard.index', compact(
            'stats', 'feedPosts', 'nextAppointment',
            'latestAppointment', 'appointmentHistory',
            'myNotifications'
        ));
    }
}