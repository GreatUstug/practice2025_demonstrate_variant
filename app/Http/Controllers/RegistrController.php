<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RegistrService;

class RegistrController extends Controller
{
    protected $registrService;
    public function __construct(RegistrService $registrService)
    {
        $this->registrService = $registrService;
    }
    public function registr(Request $request)
    {
        try{
            $token = $this->registrService->registrUser($request->all());
            return response()->json(['message' => 'User create successfulle!',
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
