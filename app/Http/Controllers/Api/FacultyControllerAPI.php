<?php

namespace App\Http\Controllers\Api; // ✅ Correct namespace

use App\Http\Controllers\Controller;
use App\Models\Faculty; // ✅ Ensure this model exists
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacultyControllerAPI extends Controller {
    public function index() {
        return response()->json(Faculty::all());
    }

    public function show($id) {
        return response()->json(Faculty::find($id));
    }

    public function store(Request $request) {
        // Validate request input
        $validatedData = $request->validate([
            'rfid_uid'  => 'required|unique:faculty,rfid_uid',
            'fname'     => 'required|string|max:100',
            'mname'     => 'nullable|string|max:100',
            'lname'     => 'required|string|max:100',
            'suffix'    => 'nullable|string|max:20',
            'admin_id'  => 'required|exists:admins,admin_id', // Ensure admin_id exists
            'status'    => 'nullable|string|in:Enabled,Disabled', // Use correct ENUM values
        ]);
    
        // Default status to 'Enabled' if not provided
        $validatedData['status'] = $validatedData['status'] ?? 'Enabled';
    
        // Generate a unique faculty_id if not provided
        $validatedData['faculty_id'] = $request->faculty_id ?? (string) Str::uuid();
    
        // Create the faculty record
        $faculty = Faculty::create($validatedData);
    
        return response()->json([
            'message' => 'Faculty member added successfully',
            'faculty' => $faculty
        ], 201);
    }

    public function update(Request $request, $id) {
        $faculty = Faculty::findOrFail($id);
        $faculty->update($request->all());
        return response()->json($faculty);
    }

    public function destroy($id) {
        Faculty::destroy($id);
        return response()->json(null, 204);
    }
}