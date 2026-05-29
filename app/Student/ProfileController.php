<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show() { return view('coming-soon', ['page' => 'My Profile']); }
}