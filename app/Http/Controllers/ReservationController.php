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
        $reservations = Reservation::with('classroom.building')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $classrooms = Classroom::with('building')->get();
        return view('reservations.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'date'         => 'required|date|after_or_equal:today',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'purpose'      => 'required|string|max:500',
        ]);

        $hasOverlap = $this->checkOverlap(
            $request->classroom_id,
            $request->date,
            $request->start_time,
            $request->end_time
        );

        if ($hasOverlap) {
            return back()
                ->withInput()
                ->withErrors(['start_time' => 'عذراً، القاعة محجوزة بالفعل خلال هذه الفترة الزمنية. اختر وقتاً آخر.']);
        }

        Reservation::create([
            'user_id'      => Auth::id(),
            'classroom_id' => $request->classroom_id,
            'date'         => $request->date,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'purpose'      => $request->purpose,
            'status'       => 'pending',
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'تم تقديم طلب الحجز بنجاح!');
    }

    public function edit(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا الحجز.');
        }

        $classrooms = Classroom::with('building')->get();
        return view('reservations.edit', compact('reservation', 'classrooms'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتحديث هذا الحجز.');
        }

        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'date'         => 'required|date|after_or_equal:today',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'purpose'      => 'required|string|max:500',
        ]);

        $hasOverlap = $this->checkOverlap(
            $request->classroom_id,
            $request->date,
            $request->start_time,
            $request->end_time,
            $reservation->id
        );

        if ($hasOverlap) {
            return back()
                ->withInput()
                ->withErrors(['start_time' => 'عذراً، التعارض الزمني موجود مع حجز آخر بنفس القاعة.']);
        }

        $reservation->update($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'تم تعديل الحجز بنجاح.');
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذا الحجز.');
        }

        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'تم إلغاء الحجز بنجاح.');
    }

    private function checkOverlap($classroomId, $date, $startTime, $endTime, $ignoreId = null)
    {
        return Reservation::where('classroom_id', $classroomId)
            ->where('date', $date) // تم التعديل إلى date
            ->where('status', '!=', 'rejected')
            ->when($ignoreId, function ($query, $id) {
                return $query->where('id', '!=', $id);
            })
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
            })
            ->exists();
    }
}
