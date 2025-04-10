<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Logs;
use App\Models\Admin;
use App\Models\LabKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function welcome()
    {
        return view('loader.welcome');
    }

    public function app()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in first.');
        }

        return view('admin.app');
    }

    public function loader()
    {
        return view('loader.loader');
    }

    public function login()
    {
        return view('admin.login');
    }
    
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Redirect to loader view first, then go to dashboard
            return response()->view('loader.loader', [
                'redirectUrl' => route('admin.dashboard')
            ]);
        }

        return back()->withInput()->with('error', 'Invalid username or password.');
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');  // Change here to 'login'
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in first.');
        }

        // Count total faculty members
        $facultyCount = Faculty::count();

        // Latest 6 unique faculty members who borrowed
        $recentFacultyBorrowed = Logs::with('borrowedBy')
            ->whereNotNull('faculty_id_borrowed')
            ->orderBy('date_time_borrowed', 'desc')
            ->get()
            ->unique('faculty_id_borrowed')
            ->take(6);

        // Latest 6 borrowed keys with lab + borrower info
        $recentBorrowedKeys = Logs::with(['borrowedBy', 'labKey'])
            ->whereNotNull('key_id')
            ->orderBy('date_time_borrowed', 'desc')
            ->limit(6)
            ->get();

        // Count borrowed keys not returned yet
        $borrowedKeysCount = Logs::whereNull('date_time_returned')->count();

        return view('admin.dashboard', compact(
            'facultyCount',
            'recentFacultyBorrowed',
            'recentBorrowedKeys',
            'borrowedKeysCount'
        ));
    }

    public function createFaculty()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Access denied.');
        }

        return view('admin.registration');
    }

    public function toggleStatus($faculty_id)
    {
        try {
            $faculty = Faculty::findOrFail($faculty_id);

            // Toggle status
            $faculty->status = $faculty->status === 'Enabled' ? 'Disabled' : 'Enabled';
            $faculty->save();   

            return redirect()->back()->with('success', "Faculty ID: {$faculty_id} status updated to {$faculty->status}.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update faculty status.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|unique:faculty,faculty_id|max:100',
            'fname' => 'required|string|max:45',
            'lname' => 'required|string|max:45',
            'rfid_uid' => 'nullable|string|max:255',
        ]);

        if (!empty($request->rfid_uid) && Faculty::where('rfid_uid', $request->rfid_uid)->exists()) {
            return redirect()->back()->with('error', 'RFID UID already exists. Please use a different one.');
        }

        // Get the currently logged-in admin's ID
        $adminId = auth()->user()->admin_id;

        // Create faculty with additional fields
        Faculty::create([
            'faculty_id' => $request->faculty_id,
            'rfid_uid' => $request->rfid_uid,
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'suffix' => $request->suffix,
            'admin_id' => $adminId,  // Store the admin who added the faculty
            'status' => 'Enabled',   // Default status
        ]);

        return redirect()->back()->with('success', 'Faculty registered successfully!');
    }

    public function labKeys()
    {
        $labKeys = LabKey::all();

        foreach ($labKeys as $key) {
            $log = Logs::with('borrowedBy')
                ->where('key_id', $key->key_id)
                ->whereNull('date_time_returned')
                ->latest('date_time_borrowed')
                ->first();

            if ($log && $log->borrowedBy) {
                $key->faculty_name = $log->borrowedBy->fname . ' ' . $log->borrowedBy->lname;
            } else {
                $key->faculty_name = 'Not borrowed';
            }
        }

        $groupedLabKeys = $labKeys->groupBy('laboratory');

        return view('admin.labkeys', compact('groupedLabKeys'));
    }

    public function storeLabKey(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'key_id' => 'required|unique:lab_keys,key_id',
            'laboratory' => 'required|string|max:255',
        ]);

        // Create a new LabKey record
        LabKey::create([
            'key_id' => $request->key_id,
            'laboratory' => $request->laboratory,
            'status' => 'Available',
        ]);

        // Redirect back with success message
        return back()->with('success', 'Laboratory Key Registered Successfully!');
    }

    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Access denied.');
        }

        $faculty = Faculty::all();
        return view('admin.list', compact('faculty'));
    }

    public function log()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Access denied.');
        }

        $logs = Logs::with(['borrowedBy', 'returnedBy', 'labKey'])->orderBy('date_time_borrowed', 'desc')->get();

        // Extract unique borrower names
        $borrowerNames = $logs->map(function ($log) {
            if ($log->borrowedBy) {
                return trim($log->borrowedBy->fname . ' ' . $log->borrowedBy->mname . ' ' . $log->borrowedBy->lname . ' ' . $log->borrowedBy->suffix);
            }            
            return 'Unknown Borrower';
        })->unique()->sort()->values();

        // Pass both logs and borrowerNames to the view
        return view('admin.logs', compact('logs', 'borrowerNames'));
    }
}
