<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hall;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::all();
        return response()->json([
            'status' => true,
            'data' => $halls
        ]);
    }

    public function show(Hall $hall)
    {
        $hall->load(['reviews.user', 'bookings']);
        return response()->json([
            'status' => true,
            'data' => $hall
        ]);
    }
}
