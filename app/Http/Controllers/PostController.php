<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['posts' => Post::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'image' => 'sometimes|image'
        ]);
        // dd($data);

        if($post = Post::create($data)){
            return response()->json(['message' => 'success', 'post' => $post], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json(['post' => $post], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required'
        ]);

        if($post->update($data)){
            return response()->json(['post' => $post], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->delete()){
            return response()->json(['message' => 'success'], 200);
        }
    }

    public function likePost(Post $post, User $user){
        // dd($user->likes());
        return $user->likes()->toggle($post->id);
    }

    public function dislikePost(Post $post, User $user){

        return $user->dislikes()->toggle($post->id);
    }

    public function upvotePost(Post $post, User $user){

        return $user->upvotes()->toggle($post->id);
    }

    public function downvotePost(Post $post, User $user){

        return $user->downvotes()->toggle($post->id);
    }

}