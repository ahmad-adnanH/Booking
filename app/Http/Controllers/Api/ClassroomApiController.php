<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomApiController extends Controller
{
    public function index()
    {
        return response()->json(Classroom::with('building')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string',
            'capacity'    => 'required|integer|min:1',
            'floor'       => 'required|integer',
            'name'        => 'nullable|string|max:255',
            'status'      => 'nullable|string|in:available,unavailable',
        ]);

        $classroom = Classroom::create($validated);

        return response()->json($classroom, 201);
    }

    public function show(Classroom $classroom)
    {
        return response()->json($classroom->load('building'), 200);
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'building_id' => 'sometimes|required|exists:buildings,id',
            'room_number' => 'sometimes|required|string',
            'capacity'    => 'sometimes|required|integer|min:1',
            'floor'       => 'sometimes|required|integer',
            'name'        => 'nullable|string|max:255',
            'status'      => 'nullable|string|in:available,unavailable',
        ]);

        $classroom->update($validated);

        return response()->json($classroom, 200);
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return response()->json([
            'message' => 'تم حذف القاعة بنجاح'
        ], 200);
    }
}
