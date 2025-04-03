<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\Faculty;
use App\Models\LabKey;
use Carbon\Carbon;

class LogsApiController extends Controller
{
    public function index() {
        return response()->json(Logs::all());
    }

    public function storeBorrowed(Request $request)
    {
        // Validate request data (basic checks)
        $validatedData = $request->validate([
            'faculty_id' => 'required|string',
            'key_id' => 'required|integer',
            'details' => 'required|string',
        ]);

        // Check if faculty_id exists in the Faculty model
        $faculty = Faculty::where('faculty_id', $request->faculty_id)->first();
        if (!$faculty) {
            return response()->json([
                'message' => 'Invalid faculty_id. No matching faculty found.',
            ], 422);
        }

        // Check if key_id exists in the LabKey model
        $labKey = LabKey::where('key_id', $request->key_id)->first();
        if (!$labKey) {
            return response()->json([
                'message' => 'Invalid key_id. No matching lab key found.',
            ], 422);
        }

        // Check if the key is already borrowed
        if ($labKey->status === 'borrowed') {
            return response()->json([
                'message' => 'The key is already borrowed.',
            ], 422);
        }

        // Update the status of the key to "borrowed"
        $labKey->update(['status' => 'borrowed']);

        // Add the current timestamp for date_time_borrowed in PH Time
        $validatedData['date_time_borrowed'] = Carbon::now('Asia/Manila');

        // Create and save the log entry
        $log = Logs::create($validatedData);

        return response()->json([
            'message' => 'Log stored successfully!',
            'log' => $log
        ], 201);
    }

    public function storeReturned(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'faculty_id' => 'required|string',
            'key_id' => 'required|integer',
        ]);

        // Find the log entry based on faculty_id and key_id
        $log = Logs::where('faculty_id', $request->faculty_id)
            ->where('key_id', $request->key_id)
            ->whereNull('date_time_returned') // Ensure the key is currently borrowed
            ->first();

        if (!$log) {
            return response()->json([
                'message' => 'No active borrowed record found for this faculty and key.',
            ], 404);
        }

        // Automatically set the current timestamp for date_time_returned in PH Time
        $log->update([
            'date_time_returned' => Carbon::now('Asia/Manila'),
        ]);

        // Update the status of the key to "available"
        $labKey = LabKey::where('key_id', $request->key_id)->first();
        if ($labKey) {
            $labKey->update(['status' => 'available']);
        }

        return response()->json([
            'message' => 'Log updated successfully!',
            'log' => $log
        ], 200);
    }

}
