<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __invoke(Post $post)
    {
        $user = request()->user();

        $post->likes()->toggle($user->id);

        return to_route('dashboard');

        // return response()->json([
        //     'liked'       => $post->isLikedBy($user->id),
        //     'likes_count' => $post->likes()->count(),
        // ]);
    }
}
