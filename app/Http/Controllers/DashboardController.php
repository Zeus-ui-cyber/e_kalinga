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
        // 1. Basic Stats
        $completedSessions = 3; // Replace with actual DB query later: $user->sessions()->where('status', 'completed')->count();
        
        // 2. Next Appointment
        $nextAppointment = (object)[
            'date' => 'Oct 24',
            'time' => '10:00 AM',
            'counselor' => 'Dr. Jake Javier'
        ];

        // 3. Session History (Mock Data)
        $recentSessions = collect([
            (object)['date' => 'Oct 24, 2026', 'time' => '10:00 AM', 'counselor' => 'Dr. Jake Javier', 'type' => 'Follow-up', 'status' => 'Upcoming', 'badge' => 'bg-yellow'],
            (object)['date' => 'Sep 30, 2026', 'time' => '02:00 PM', 'counselor' => 'Dr. Jake Javier', 'type' => 'Initial Intake', 'status' => 'Completed', 'badge' => 'bg-green'],
        ]);

        // 4. Community Feed (Mock Data)
        $feedPosts = collect([
            (object)[
                'author' => 'PLSP Counseling Office',
                'tag' => 'Announcement',
                'time_ago' => '2h ago',
                'content' => 'Midterms are approaching! We are hosting a "De-stress & Mingle" session this Friday at the campus gazebo.',
                'likes' => 42,
                'replies' => 5
            ],
            (object)[
                'author' => 'Anonymous Student',
                'tag' => 'Peer Support',
                'time_ago' => '5h ago',
                'content' => 'Feeling really overwhelmed with my Capstone Project right now. Does anyone have tips on how to handle burnout?',
                'likes' => 18,
                'replies' => 12
            ]
        ]);

        // 5. Recent Chats (Mock Data)
        $recentChats = collect([
            (object)['name' => 'Dr. Jake Javier', 'icon' => 'ti-stethoscope', 'preview' => 'Please remember to fill out your DASS-21...', 'time' => '10:42 AM', 'unread' => true],
            (object)['name' => 'System Support', 'icon' => 'ti-user-shield', 'preview' => 'Your profile update was successful.', 'time' => 'Yesterday', 'unread' => false],
        ]);

        // Pass all variables to the view
        return view('dashboard.index', compact(
            'completedSessions', 
            'nextAppointment', 
            'recentSessions', 
            'feedPosts', 
            'recentChats'
        ));
    }
}