<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrController extends Controller
{
    public function registr(Request $request)
    {
        try{
            $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255',       
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);
            
            $user = User::create($validatedData, );

            $token = $user->createToken($request->input('device_name') ?: 'default_device')->plainTextToken;

            return response()->json(['message' => 'User create successfulle!',
                                           'user' => $user,
                                           'access_token' => $token,
                                           'token_type' => 'Bearer',
                                            201]);
        } catch (\Throwable $e) {
            return response()->json([
            'message' => 'Internal server error',
            'details' => $e->getMessage()
            ], 500);
        }
    }
}
