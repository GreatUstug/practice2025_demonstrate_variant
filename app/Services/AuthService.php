<?php

namespace App\Services;

use App\Models\User;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function authUser(array $data): array
    {
        UserValidator::validateAuth($data);

        $user = User::where('email', $data['email'])->first();

        // if (!$user || !Hash::check($data['password'], $user->password)) {
        // throw new \Exception("User does not exists", 404);
        // }
        $deviceName = $data['device_name'] ?? 'default_device';

        return [
            'token' => $user->createToken($deviceName)->plainTextToken,
            'user_id' => $user->id,
        ];
    }
}
?>