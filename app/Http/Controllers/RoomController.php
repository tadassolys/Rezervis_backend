<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;


class RoomController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if ($startDate && $endDate) {
            // Filter rooms that are not reserved in the given period or have a status of "cancelled"
            $rooms = Room::whereDoesntHave('reservations', function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })->orWhereHas('reservations', function ($query) {
                $query->where('status', 'cancelled');
            })->get();
        } else {
            $rooms = Room::all();
        }

        return response()->json($rooms);
    }

    public function show($id)
    {
        $room = Room::find($id);
        if ($room) {
            return response()->json($room);
        } else {
            return response()->json(['message' => 'Room not found'], 404);
        }
    }
}
