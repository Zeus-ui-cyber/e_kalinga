<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function index() { return view('coming-soon', ['page' => 'Session History']); }
}