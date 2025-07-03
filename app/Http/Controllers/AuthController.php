<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{

    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        try {
            
            $result = $this->authService->authUser($request->all());

            return response()->json([
                'access_token' => $result['token'],
                'token_type' => 'Bearer',
                'user_id' => $result['user_id'],
            ], 200);
          }
        catch (\Throwable $e) {
              return response()->json([
                  'message' => 'Error during request processing.',
                  'details' => $e->getMessage()
              ], 400);
          }
    }
}