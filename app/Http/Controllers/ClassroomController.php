<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController
{
    /**
     * Display a listing of the resource.
     */
public function index()
    {
        $classrooms = Classroom::with('building');
        return view('classrooms.index', compact('classrooms'));
    }


 public function create(Request $request)
{
    $buildings = Building::all();
    $selectedBuildingId = $request->query('building_id');

    return view('classrooms.create', compact('buildings', 'selectedBuildingId'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:50',
            'name'        => 'nullable|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'floor'       => 'required|integer',
            'status'      => 'required|in:available,maintenance',
        ]);

        Classroom::create($validated);

        return redirect()->route('classrooms.index')
            ->with('success', 'تم إضافة القاعة بنجاح');
    }


    public function show(Classroom $classroom)
    {
        $classroom->load(['building', 'reviews.user']);
        return view('classrooms.show', compact('classroom'));
    }


    public function edit(Classroom $classroom)
    {
        $buildings = Building::all();
        return view('classrooms.edit', compact('classroom', 'buildings'));
    }


    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:50',
            'name'        => 'nullable|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'floor'       => 'required|integer',
            'status'      => 'required|in:available,maintenance',
        ]);

        $classroom->update($validated);

        return redirect()->route('classrooms.index')
            ->with('success', 'تم تحديث بيانات القاعة بنجاح');
    }


    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect()->route('classrooms.index')
            ->with('success', 'تم حذف القاعة بنجاح');
    }
}
