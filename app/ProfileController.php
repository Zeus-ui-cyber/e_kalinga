<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('coming-soon', ['page' => 'Account Settings']);
    }

    public function update(Request $request)
    {
        return redirect()->route('profile.edit');
    }
}