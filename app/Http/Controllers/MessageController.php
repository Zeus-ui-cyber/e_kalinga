<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('coming-soon', ['page' => 'Messages']);
    }

    public function show($thread)
    {
        return view('coming-soon', ['page' => 'Messages']);
    }

    public function send(Request $request, $thread)
    {
        return redirect()->route('messages.index');
    }
}