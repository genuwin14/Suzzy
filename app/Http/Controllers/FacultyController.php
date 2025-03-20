<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyController extends Controller
{
        public function index()
    {
        $faculty = Faculty::all();
        return view('faculty.index', compact('faculty'));
    }

    public function create()
    {
        return view('faculty_registration');
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|unique:faculty,faculty_id|max:100',
            'fname' => 'required|string|max:45',
            'lname' => 'required|string|max:45',
            'rfid_uid' => 'nullable|string|max:255|unique:faculty,rfid_uid',
        ]);

        Faculty::create($request->all());

        return redirect()->back()->with('success', 'Faculty registered successfully!');
    }
}
