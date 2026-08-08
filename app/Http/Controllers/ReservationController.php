<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['classroom.building', 'user'])->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $classrooms = Classroom::with('building')->where('status', 'available')->get();
        return view('reservations.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
    'classroom_id' => 'required|exists:classrooms,id',
    'date'         => 'required|date',
    'start_time'   => 'required',
    'end_time'     => 'required|after:start_time',
    'purpose'      => 'required|string|max:500', 
]);


        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';
        try {
            Reservation::create($validated);

            return redirect()->route('reservations.index')
                ->with('success', 'تم تسجيل طلب الحجز بنجاح!');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()]);
        }
    }
}
