<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()   { return view('coming-soon', ['page' => 'Student Records']); }
    public function create()  { return view('coming-soon', ['page' => 'Add Student']); }
    public function store(Request $request) { return redirect()->route('admin.students.index'); }
    public function show($id) { return view('coming-soon', ['page' => 'Student Record']); }
    public function edit($id) { return view('coming-soon', ['page' => 'Edit Student']); }
    public function update(Request $request, $id) { return redirect()->route('admin.students.index'); }
    public function destroy($id) { return redirect()->route('admin.students.index'); }
}