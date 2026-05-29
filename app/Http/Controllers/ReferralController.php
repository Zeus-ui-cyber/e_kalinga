<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Referral;

class ReferralController extends Controller
{
    /**
     * Display all referrals (Admin only)
     */
    public function index()
    {
        $referrals = Referral::latest()->get();

        return view('admin.referrals.index', compact('referrals'));
    }

    /**
     * Store a new referral (optional if you use it)
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'reason' => 'required|string',
        ]);

        Referral::create([
            'student_name' => $request->student_name,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Referral created successfully.');
    }

    /**
     * Show a single referral (optional)
     */
    public function show(Referral $referral)
    {
        return view('admin.referrals.show', compact('referral'));
    }

    /**
     * Delete referral (optional)
     */
    public function destroy(Referral $referral)
    {
        $referral->delete();

        return back()->with('success', 'Referral deleted successfully.');
    }
}