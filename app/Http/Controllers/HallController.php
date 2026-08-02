<?php

namespace App\Http\Controllers;

use App\Models\Hall;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::all();
        return view('halls.index', compact('halls'));
    }

    public function show(Hall $hall)
    {
        $hall->load(['reviews.user', 'bookings']);
        return view('halls.show', compact('hall'));
    }
}
