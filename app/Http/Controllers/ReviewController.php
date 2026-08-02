<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * إضافة تقييم وملاحظة لحجز مكتمل (مرة واحدة فقط ودون إمكانية التعديل أو الحذف لاحقاً)
     */
    public function store(Request $request, Booking $booking)
    {
        // 1. التأكد من أن المستخدم هو صاحب الحجز
        if ($booking->user_id !== $request->user()->id) {
            return response()->json([
                'status'  => false,
                'message' => 'غير مصرح لك بإضافة تقييم لهذا الحجز'
            ], 403);
        }

        // 2. التأكد من عدم تقييم الحجز نفسه سابقاً
        if ($booking->review()->exists()) {
            return response()->json([
                'status'  => false,
                'message' => 'لقد قمت بإضافة تقييم وملاحظة لهذا الحجز من قبل، ولا يمكن تعديلها أو إضافتها مجدداً.'
            ], 400);
        }

        // 3. التأكد من انتهاء موعد الحجز كلياً
        $bookingEnd = Carbon::parse($booking->booking_date . ' ' . $booking->end_time);
        if (now()->lessThan($bookingEnd)) {
            return response()->json([
                'status'  => false,
                'message' => 'لا يمكنك تقييم القاعة وإضافة ملاحظات إلا بعد انتهاء موعد الحجز.'
            ], 400);
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'user_id'    => $request->user()->id,
            'hall_id'    => $booking->hall_id,
            'booking_id' => $booking->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'تم إضافة تقييمك وملاحظتك بنجاح.',
            'data'    => new ReviewResource($review->load(['user', 'hall']))
        ], 201);
    }
}
