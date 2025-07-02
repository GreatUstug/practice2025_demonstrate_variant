<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AllPostsService;

class AllPostsController extends Controller
{
    
    protected $showAllService;

    public function __construct(AllPostsService $showAllService)
    {
        $this->showAllService = $showAllService;
    }

    public function showall(Request $request)
    {
        try {
            $publications = $this->showAllService->getAllPosts($request);
            return response()->json($publications, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Internal server error',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
