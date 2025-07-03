<?php

namespace App\Services;

use App\Models\User;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\Hash;

class RegistrService
{
    public function registrUser(array $data): string
    {
        UserValidator::validateRegistr($data);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $deviceName = $data['device_name'] ?? 'default_device';
        $token = $user->createToken($deviceName)->plainTextToken;
        return $token;
    }
}
?>