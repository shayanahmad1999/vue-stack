<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): Response
    {
        $posts = auth()->user()->posts()->latest()->paginate(10)->withQueryString();
        return Inertia::render('posts/Index', [
            'posts' => PostResource::collection($posts),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ],

        ]);
    }
}
