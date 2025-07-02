<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AllMyPostsService;
class AllMyPostsController extends Controller
{
    protected $showAllMyService;

    public function __construct(AllMyPostsService $showAllMyService)
    {
        $this->showAllMyService = $showAllMyService;
    }
    
    public function showallmy(Request $request)
    {
        try {
            $publications = $this->showAllMyService->getAllMyPosts($request);
            return response()->json($publications, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Internal server error',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
