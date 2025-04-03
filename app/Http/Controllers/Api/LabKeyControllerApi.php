<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LabKey;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LabKeyControllerApi extends Controller
{
    public function index() {
        return response()->json(LabKey::all());
    }

    public function show($id) {
        return response()->json(LabKey::find($id));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'key_id' => 'required|string|unique:lab_keys,key_id',
                'laboratory' => 'nullable|string',
                'status' => 'nullable|string',
            ]);

            $key = LabKey::create($validated);

            return response()->json([
                'message' => 'Key stored successfully',
                'data' => $key
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
