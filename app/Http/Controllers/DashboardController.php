<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FeedPost;

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
            'total_students'  => User::where('role', 'student')->count(),
            'active_cases'    => 0,
            'referrals'       => 0,
            'unread_messages' => 0,
        ];

        $recentStudents = User::where('role', 'student')
            ->orderByDesc('created_at')
            ->take(8)
            ->get()
            ->map(function ($s) {
                $s->last_session_at = null;
                return $s;
            });

        $trends = [
            ['label' => 'Academic stress', 'pct' => 45],
            ['label' => 'Family issues',   'pct' => 28],
            ['label' => 'Mental health',   'pct' => 19],
            ['label' => 'Other',           'pct' => 8],
        ];

        return view('dashboard.index', compact('stats', 'recentStudents', 'trends'));
    }

    private function studentDashboard(User $user)
{
    $stats = [
        'sessions'      => 0,
        'messages_sent' => 0,
    ];

    $nextAppointment = null;
    $feedPosts = collect(); // empty for now until Feed module is built

    return view('dashboard.index', compact('stats', 'nextAppointment', 'feedPosts'));
}
}