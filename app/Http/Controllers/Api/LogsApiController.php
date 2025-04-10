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
        // Validate request data
        $validatedData = $request->validate([
            'faculty_id' => 'required|string',
            'key_id'     => 'required|integer',
            'details'    => 'required|string',
        ]);

        // Check if faculty exists
        $faculty = Faculty::where('faculty_id', $request->faculty_id)->first();
        if (!$faculty) {
            return response()->json([
                'message' => 'Invalid faculty_id. No matching faculty found.',
            ], 422);
        }

        // Check if lab key exists
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

        // Update key status
        $labKey->update(['status' => 'borrowed']);

        // Prepare log data
        $log = Logs::create([
            'faculty_id_borrowed'   => $request->faculty_id,
            'faculty_id_returned'   => null,
            'key_id'                => $request->key_id,
            'details'               => $request->details,
            'date_time_borrowed'    => Carbon::now('Asia/Manila'),
        ]);

        return response()->json([
            'message' => 'Log stored successfully!',
            'log' => $log
        ], 201);
    }

    public function storeReturned(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'faculty_id' => 'required|string', // This is the returning faculty
            'key_id'     => 'required|integer',
        ]);

        // Find the active borrowed log using only key_id and return status
        $log = Logs::where('key_id', $request->key_id)
            ->whereNull('date_time_returned')
            ->first();

        if (!$log) {
            return response()->json([
                'message' => 'No active borrowed record found for this key.',
            ], 404);
        }

        // Update log: return timestamp and returner faculty ID
        $log->update([
            'date_time_returned'  => Carbon::now('Asia/Manila'),
            'faculty_id_returned' => $request->faculty_id,
        ]);

        // Set key status to available
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
