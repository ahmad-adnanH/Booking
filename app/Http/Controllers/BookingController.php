<?php


namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings
            ->load('hall')
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $halls = Hall::all();
        return view('bookings.create', compact('halls'));
    }

   public function store(Request $request)
{
    // 1. التحقق من صحة المدخلات
    $request->validate([
        'hall_id'      => 'required|exists:halls,id',
        'booking_date' => 'required|date|after_or_equal:today',
        'start_time'   => 'required|date_format:H:i',
        'end_time'     => 'required|date_format:H:i|after:start_time',
        'reason'       => 'required|string|max:500',
    ]);

    $hasConflict = Booking::where('hall_id', $request->hall_id)
        ->where('booking_date', $request->booking_date)
        ->where(function ($query) use ($request) {
            $query->where('start_time', '<', $request->end_time)
                  ->where('end_time', '>', $request->start_time);
        })
        ->exists();

    if ($hasConflict) {
        return back()
            ->withInput()
            ->withErrors(['time_conflict' => 'القاعة محجوزة بالفعل في هذا الوقت والتاريخ. اختر وقتاً آخر.']);
    }

    Booking::create([
        'user_id'      => auth()->id(),
        'hall_id'      => $request->hall_id,
        'booking_date' => $request->booking_date,
        'start_time'   => $request->start_time,
        'end_time'     => $request->end_time,
        'reason'       => $request->reason,
    ]);

    return redirect()->route('bookings.index')->with('success', 'تم إنشاء الحجز بنجاح.');
}

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);
        $halls = Hall::all();
        return view('bookings.edit', compact('booking', 'halls'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $request->validate([
            'hall_id' => 'required|exists:halls,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'required|string|max:500',
        ]);

        // التحقق من التعارض مع استثناء الحجز الحالي
        $hasConflict = Booking::where('hall_id', $request->hall_id)
            ->where('booking_date', $request->booking_date)
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })
            ->exists();

        if ($hasConflict) {
            return back()->withInput()->withErrors(['time_conflict' => 'القاعة محجوزة بالفعل في هذا الوقت والتاريخ.']);
        }

        $booking->update($request->only(['hall_id', 'booking_date', 'start_time', 'end_time', 'reason']));

        return redirect()->route('bookings.index')->with('success', 'تم تعديل الحجز بنجاح');
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'تم إلغاء الحجز بنجاح');
    }
}
