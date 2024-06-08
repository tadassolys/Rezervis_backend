<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\VehicleController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/rooms', [RoomController::class, 'index']); // Fetch rooms
Route::get('/equipment', [EquipmentController::class, 'index']);
Route::get('/vehicles', [VehicleController::class, 'index']);

// Fetch individual items by ID
Route::get('/rooms/{id}', [RoomController::class, 'show']);
Route::get('/equipment/{id}', [EquipmentController::class, 'show']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);


// Authentication routes
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/reservations', [ReservationController::class, 'store']); // Make a reservation

Route::middleware('auth:sanctum')->get('/active-reservations', [ReservationController::class, 'activeReservations']);

Route::middleware('auth:sanctum')->get('/past-reservations', [ReservationController::class, 'pastReservations']);

Route::middleware('auth:sanctum')->patch('/cancel-reservation/{id}', [ReservationController::class, 'cancelReservation']);


