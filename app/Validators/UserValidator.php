<?php
namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator
{
    public static function validateRegistr(array $data)
    {
        Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|max:255',
            'device_name' => 'nullable|string|max:255'  
        ])->validate();
    }

    public static function validateAuth(array $data)
    {
        Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable|string|max:255'
        ])->validate();
    }
}
?>