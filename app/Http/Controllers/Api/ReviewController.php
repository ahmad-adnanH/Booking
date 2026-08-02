<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'غير مصرح لك بتقديم تقييم لهذا الحجز'], 403);
        }

        // الشرط: التأكد من انقضاء وقت الحجز
        $bookingEnd = \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->end_time);
        if (now()->lessThan($bookingEnd)) {
            return response()->json([
                'status' => false,
                'message' => 'لا يمكنك تقييم القاعة إلا بعد انتهاء الحجز.'
            ], 400);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'user_id' => $request->user()->id,
            'hall_id' => $booking->hall_id,
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تمت إضافة التقييم بنجاح',
            'data' => $review
        ], 201);
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json(['message' => ' غير مصرح لك بتعديل هذا التقييم'], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($request->only(['rating', 'comment']));

        return response()->json([
            'status' => true,
            'message' => 'تم تعديل التقييم بنجاح',
            'data' => $review
        ]);
    }

    public function destroy(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json(['message' => 'غير مصرح لك بحذف هذا التقييم'], 403);
        }

        $review->delete();

        return response()->json([
            'status' => true,
            'message' => 'تم حذف التقييم بنجاح'
        ]);
    }
}
