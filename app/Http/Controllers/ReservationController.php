<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // Map reservable types to their corresponding model classes and database tables
        $reservableTypes = [
            'room' => ['model' => 'App\Models\Room', 'table' => 'rooms'],
            'equipment' => ['model' => 'App\Models\Equipment', 'table' => 'equipment'],
            'vehicle' => ['model' => 'App\Models\Vehicle', 'table' => 'vehicles'],
        ];

        $reservableInfo = $reservableTypes[$request->reservation_type] ?? null;

        if (!$reservableInfo) {
            return response()->json(['message' => 'Invalid reservable type'], 422);
        }

        $request->validate([
            'reservable_id' => "required|exists:{$reservableInfo['table']},id",
            'reservation_type' => 'required|string|in:' . implode(',', array_keys($reservableTypes)),
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 403);
        }

        $reservation = new Reservation([
            'user_id' => $user->id,
            'reservable_id' => $request->reservable_id,
            'reservable_type' => $reservableInfo['model'],
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);
        $reservation->save();

        return response()->json(['message' => 'Reservation successful'], 200);
    }


    public function activeReservations()
    {
        $user = Auth::user(); 
        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 403);
        }

        // Fetch active reservations that are not cancelled
        $reservations = Reservation::where('user_id', $user->id)
            ->where('start_date', '>=', now())
            ->where('status', '!=', 'cancelled') // Exclude cancelled reservations
            ->get();

        return response()->json($reservations);
    }


    public function pastReservations()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 403);
        }

        // Fetch reservations that ended before today or are cancelled
        $reservations = Reservation::where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('end_date', '<', now())
                    ->orWhere('status', '=', 'cancelled');
            })
            ->get();

        return response()->json($reservations);
    }


    public function cancelReservation($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 403);
        }

        $reservation = Reservation::where('id', $id)->where('user_id', $user->id)->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->status = 'cancelled';
        $reservation->save();

        return response()->json(['message' => 'Reservation cancelled successfully'], 200);
    }
}
