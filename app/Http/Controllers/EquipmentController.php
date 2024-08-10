<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;


class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if ($startDate && $endDate) {
            $equipment = Equipment::whereDoesntHave('reservations', function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                });
            })->orWhereHas('reservations', function ($query) {
                $query->where('status', 'cancelled');
            })->get();
        } else {
            $equipment = Equipment::all();
        }

        return response()->json($equipment);
    }

    public function show($id)
    {
        $equipment = Equipment::find($id);

        if ($equipment) {
            return response()->json($equipment);
        } else {
            return response()->json(['message' => 'Equipment not found'], 404);
        }
    }

}
