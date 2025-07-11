<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AllMyPostsService
{
    public function getAllMyPosts(Request $request)
    {
        $user_id = Auth::id();
        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'desc');
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $startdate = $request->input('startdate', null);
        $enddate = $request->input('enddate', null);

        $publicationsQuery = Post::select('*');
        $publicationsQuery->where('user_id', $user_id);
        $publicationsQuery
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
        return $publications;
    }
}
