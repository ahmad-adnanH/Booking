<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * عرض جميع حجوزات المستخدم الحالي (القادمة والمستقبلية)
     */
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()
            ->with(['hall', 'review'])
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'تم جلب الحجوزات بنجاح',
            'data'    => BookingResource::collection($bookings)
        ], 200);
    }

    /**
     * عرض سجل الحجوزات السابقة (المنتهية) فقط
     */
    public function history(Request $request)
    {
        $today = now()->toDateString();
        $currentTime = now()->toTimeString();

        $historyBookings = $request->user()->bookings()
            ->with(['hall', 'review'])
            ->where(function ($query) use ($today, $currentTime) {
                $query->where('booking_date', '<', $today)
                      ->orWhere(function ($q) use ($today, $currentTime) {
                          $q->where('booking_date', '=', $today)
                            ->where('end_time', '<=', $currentTime);
                      });
            })
            ->orderBy('booking_date', 'desc')
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'تم جلب سجل الحجوزات السابقة بنجاح',
            'data'    => BookingResource::collection($historyBookings)
        ], 200);
    }

    /**
     * إنشاء حجز جديد مع التحقق من التعارض الزمنـي
     */
    public function store(Request $request)
    {
        $request->validate([
            'hall_id'      => 'required|exists:halls,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'reason'       => 'required|string|max:500',
        ]);

        // معادلة منع تعارض الوقت في نفس القاعة
        $hasConflict = Booking::where('hall_id', $request->hall_id)
            ->where('booking_date', $request->booking_date)
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
            return response()->json([
                'status'  => false,
                'message' => 'القاعة محجوزة بالفعل في هذا الوقت والتاريخ. يرجى اختيار وقت آخر.'
            ], 422);
        }

        $booking = $request->user()->bookings()->create([
            'hall_id'      => $request->hall_id,
            'booking_date' => $request->booking_date,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'reason'       => $request->reason,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'تم إنشاء الحجز بنجاح',
            'data'    => new BookingResource($booking->load('hall'))
        ], 201);
    }

    /**
     * عرض تفاصيل حجز محدد
     */
    public function show(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json([
                'status'  => false,
                'message' => 'غير مصرح لك بزيارة هذا الحجز'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'data'   => new BookingResource($booking->load(['hall', 'review']))
        ], 200);
    }

    /**
     * تعديل حجز قائم (الخاص بالمستخدم فقط)
     */
    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json([
                'status'  => false,
                'message' => 'غير مصرح لك بتعديل هذا الحجز'
            ], 403);
        }

        $request->validate([
            'hall_id'      => 'required|exists:halls,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'reason'       => 'required|string|max:500',
        ]);

        // التعارض مع استثناء نفس الحجز المُراد تعديله
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
            return response()->json([
                'status'  => false,
                'message' => 'القاعة محجوزة بالفعل في الموعد الجديد.'
            ], 422);
        }

        $booking->update($request->only(['hall_id', 'booking_date', 'start_time', 'end_time', 'reason']));

        return response()->json([
            'status'  => true,
            'message' => 'تم تعديل الحجز بنجاح',
            'data'    => new BookingResource($booking->load('hall'))
        ], 200);
    }

    /**
     * حذف/إلغاء حجز
     */
    public function destroy(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json([
                'status'  => false,
                'message' => 'غير مصرح لك بحذف هذا الحجز'
            ], 403);
        }

        $booking->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم إلغاء الحجز بنجاح'
        ], 200);
    }
}
