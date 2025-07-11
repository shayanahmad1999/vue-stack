<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikedPostController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $likedPosts = $user->likedPosts()
            ->with('user:id,name')
            ->withCount('likes')
            ->get()
            ->map(function ($post) use ($user) {
                $post->liked = true;
                return $post;
            });

        return inertia('LikedPosts', [
            'posts' => $likedPosts,
        ]);
    }
}
