<?php

namespace App\Http\Controllers;

use App\Services\PostCreateService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostCreateService $postService)
    {
        $this->postService = $postService;
    }
    public function store(Request $request)
    {
        try {
            $post = $this->postService->createPost($request->all());
            return response()->json(['message' => 'Пост успешно создан!', 'post' => $post], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Server Error',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
