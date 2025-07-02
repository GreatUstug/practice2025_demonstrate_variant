<?php
namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class PostValidator
{
    public static function validateCreate(array $data)
    {
        Validator::make($data, [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ])->validate();
    }
}
?>