<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // compare the provided password with the hashed password
        if ($user && Hash::check($request->password, $user->password)) {
            // Revoke all tokens...
            $user->tokens()->delete();

            // Create a new token for the user
            $token = $user->createToken('api-token')->plainTextToken;

            $userData = $user->makeHidden(['password', 'remember_token'])->toArray();

            return response()->json([
                'message' => 'Login successful.',
                'user' => $userData,
                'token' => $token, // Return token
            ]);
        } else {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }
    }
}
