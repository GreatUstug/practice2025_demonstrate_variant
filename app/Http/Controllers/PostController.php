<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',       
            ]);

            $post = Post::create($validatedData, );
            return response()->json(['message' => 'Пост успешно создан!', 'post' => $post], 201);
        } catch (\Throwable $e) {
            return response()->json([
            'message' => 'Internal server error',
            'details' => $e->getMessage()
            ], 500);
        }
    }
}