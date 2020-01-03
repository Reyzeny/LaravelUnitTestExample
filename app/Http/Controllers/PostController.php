<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index() {
        return Post::all();
    }

    public function store(Request $request) {
        $post = Post::create($request->all());
        return $post;
    }

    public function show(Post $post) {
        return $post;
    }

    public function update(Request $request, Post $post) {
        $post->update($request->all());
        return response()->json($post);
    }

    public function delete(Post $post) {
        $post->delete();
        return response()->json(null, 204);
    }
}
