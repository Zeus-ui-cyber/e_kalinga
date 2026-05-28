<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        return view('coming-soon', ['page' => 'Org Feed']);
    }

    public function show($post)
    {
        return view('coming-soon', ['page' => 'Org Feed']);
    }

    public function create()
    {
        return view('coming-soon', ['page' => 'Create Post']);
    }

    public function store(Request $request)
    {
        return redirect()->route('feed.index');
    }

    public function edit($post)
    {
        return view('coming-soon', ['page' => 'Edit Post']);
    }

    public function update(Request $request, $post)
    {
        return redirect()->route('feed.index');
    }

    public function destroy($post)
    {
        return redirect()->route('feed.index');
    }
}