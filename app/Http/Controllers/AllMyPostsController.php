<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class AllMyPostsController extends Controller
{
    public function showallmy(Request $request)
    {
        try {
            $user_id = Auth::id();
            $sortBy = $request->input('sort_by', 'created_at');
            $order = $request->input('order', 'desc');
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);

            $publicationsQuery = Post::select('*');
            $publicationsQuery -> where('user_id', $user_id);
            $startdate = $request->input('startdate');
            $enddate = $request->input('enddate');

            $publicationsQuery = Post::select('*')
                ->when($startdate, function ($query) use ($startdate) {
                                        $query->where('created_at', '>=', $startdate);
                                    })
                ->when($enddate, function ($query) use ($enddate) {
                                        $query->where('created_at', '<=', $enddate);
                                    });

            
            if (in_array($sortBy, ['title', 'created_at'])) {
                $publicationsQuery->orderBy($sortBy, $order);
            }
            $publications = $publicationsQuery->skip($offset)->take($limit)->get();

            return response()->json($publications, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Internal server error',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
