<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()  { return view('coming-soon', ['page' => 'Referrals']); }
    public function store(Request $request) { return redirect()->route('admin.referrals.index'); }
    public function update(Request $request, $ref) { return redirect()->route('admin.referrals.index'); }
}