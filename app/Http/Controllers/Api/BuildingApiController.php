<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingApiController extends Controller
{
    public function index()
    {
        return response()->json(Building::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
        ]);

        $building = Building::create($validated);

        return response()->json($building, 201);
    }

    public function show(Building $building)
    {
        return response()->json($building->load('classrooms'), 200);
    }

    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:50',
        ]);

        $building->update($validated);

        return response()->json($building, 200);
    }

    public function destroy(Building $building)
    {
        $building->delete();

        return response()->json([
            'message' => 'تم حذف المبنى بنجاح'
        ], 200);
    }
}
