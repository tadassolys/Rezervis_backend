<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if ($startDate && $endDate) {
            $vehicles = Vehicle::whereDoesntHave('reservations', function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                });
            })->orWhereHas('reservations', function ($query) {
                $query->where('status', 'cancelled');
            })->get();
        } else {
            $vehicles = Vehicle::all();
        }

        return response()->json($vehicles);
    }

    public function show($id)
    {
        $vehicle = Vehicle::find($id);

        if ($vehicle) {
            return response()->json($vehicle);
        } else {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }
    }
}
