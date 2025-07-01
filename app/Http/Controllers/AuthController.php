<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;

class AuthController extends Controller
{
    use ValidatesRequests;

    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'string|max:255',
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json([
                    'message' => 'Invalid data or user does not exist.',
                ], 404);
            }

            $token = $user->createToken($request->input('device_name') ?: 'default_device')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_id' => $user->id,
            ], 201);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Error during request processing.',
            ], 400);
        }
    }
}