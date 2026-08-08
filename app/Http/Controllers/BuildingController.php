<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BuildingController extends Controller
{

public function index()
{
    $buildings = Building::with('classrooms')->get();

    return view('buildings.index', compact('buildings'));
}

public function create()
    {
        return view('buildings.create');
    }


public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:buildings,code',
            'description' => 'nullable|string',
        ]);

        Building::create($validated);

        return redirect()->route('buildings.index')
            ->with('success', 'تم إضافة المبنى بنجاح');
    }


   public function show(Building $building)
    {
        $building->load('classrooms');
        return view('buildings.show', compact('building'));
    }


    public function edit(Building $building)
    {
        return view('buildings.edit', compact('building'));
    }


  public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:buildings,code,' . $building->id,
            'description' => 'nullable|string',
        ]);

        $building->update($validated);

        return redirect()->route('buildings.index')
            ->with('success', 'تم تحديث بيانات المبنى بنجاح');
    }


    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()->route('buildings.index')
            ->with('success', 'تم حذف المبنى بنجاح');
    }
}
