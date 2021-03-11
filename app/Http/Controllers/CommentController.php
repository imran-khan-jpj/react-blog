<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        //
    }

    public function likeComment(Post $post, Comment $comment){
        $user = User::find(1);
        return $user->commentLike()->attach($comment->id);
    }

    public function dislikeComment(Post $post, Comment $comment){
        $user = User::find(1);
        return $user->commentDisike()->attach($comment->id);
    }
    public function destroy(Post $post, Comment $comment)
    {   
        $user = User::find(1);
        $comment->delete();
        return response()->json(['res' => 'success'], 200);
    }
}
