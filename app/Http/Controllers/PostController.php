<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function index()
    {
        $postRelations = ['likesBy', 'dislikesBy', 'upvoteBy', 'downvoteBy'];
        return response()->json([
            'posts'      => Post::with(['user', 'category'])->latest()->get(),
            'postLikes'  => Post::with($postRelations)->get()->map(function($item){return [
                'total_likes' => count($item->likesBy->pluck('id')),
                'post_id' => $item->id,
                'authUserLikeThisPost' => auth()->check() ? in_array(auth()->user()->id, $item->likesBy->pluck('id')->toArray()) : false,
                'authUserDislikeThisPost' => auth()->check() ? in_array(auth()->user()->id, $item->dislikesBy->pluck('id')->toArray()) :false,
                'authUserUpvoteThisPost' => auth()->check() ? in_array(auth()->user()->id, $item->upvoteBy->pluck('id')->toArray()) :false,
                'authUserDownvoteThisPost' => auth()->check() ? in_array(auth()->user()->id, $item->downvoteBy->pluck('id')->toArray()) :false,
                // 'authUserSavedThisPost' => in_array(auth()->user()->id, auth()->user()->savePost()->pluck('id')->toArray()),
                'authUserSavedThisPost' => auth()->check() ? in_array($item->id, auth()->user()->savePost()->get()->pluck('id')->toArray()) : false,
                'total_comments' => count($item->comments),
                'comments' => $item->comments()->latest()->paginate(5)->map(function($single){return [
                    'comment'   => $single->comment,
                    'user_id'   => $single->user->id,
                    'user_name' => $single->user->name,
                ];}),
                'post_report_count' => count($item->postReport)
            
            ];})
        ], 200);
    }
    public function postSaved(Request $request, User $user)
    {
        // return $user->id;
        $posts = auth()->user()->savePost()->with('user', 'category')->latest()->get();
        $postRelations = ['likesBy', 'dislikesBy', 'upvoteBy', 'downvoteBy'];
        // return $posts;
        return response()->json([
            'posts' => $posts,
            'postLikes'  => $posts->map(function($item){return [
                'total_likes' => count($item->likesBy->pluck('id')),
                'post_id' => $item->id,
                'authUserLikeThisPost' => in_array(auth()->user()->id, $item->likesBy->pluck('id')->toArray()),
                'authUserDislikeThisPost' => in_array(auth()->user()->id, $item->dislikesBy->pluck('id')->toArray()),
                'authUserUpvoteThisPost' => in_array(auth()->user()->id, $item->upvoteBy->pluck('id')->toArray()),
                'authUserDownvoteThisPost' => in_array(auth()->user()->id, $item->downvoteBy->pluck('id')->toArray()),
                // 'authUserSavedThisPost' => $item->user->id === $user->id ? true : false,
                'authUserSavedThisPost' => $item->user->id === auth()->user()->id ? true : false,
                'total_comments' => count($item->comments),
                'comments' => $item->comments()->latest()->paginate(5)->map(function($single){return [
                    'comment'   => $single->comment,
                    'user_id'   => $single->user->id,
                    'user_name' => $single->user->name,
                ];}),
                'post_report_count' => count($item->postReport)
            
            ];})
            
        ], 200);
    }
    public function store(Request $request)
    {
       
        if(auth()->check()){
            
            $request->merge(['user_id' => auth()->user()->id]);
            $data = $request->validate([
                'title' => 'required',
                'description' => 'required',
                'category_id' => 'required',
                'user_id' => 'required',
                'image' => 'sometimes|file|image|max:20000'
            ]);
    
            if($post = Post::create($data)){
                if($request->has('image')){
                    return $post->update(['image' => $request->image->store('/uploads', 'public')]);
                    return $request->image->store('uploads', 'public');
                    $post->update(['image' => $request->image->store('uploads', 'public')]);
                    // return $post;
                }
                return response()->json(['message' => 'success', 'post' => $post], 201);
            }
        }
        
    }

    public function show(Post $post)
    {
        return response()->json(['post' => $post], 200);
    }

  
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'image' => 'sometimes|image'
        ]);

        if($post->update($data)){
            return response()->json(['post' => $post], 200);
        }
    }

    public function destroy(Post $post)
    {
        if($post->delete()){
            return response()->json(['message' => 'success'], 200);
        }
    }

    public function likePost(Post $post, User $user){
        return $user->likes()->toggle($post->id);
    }

    public function dislikePost(Post $post, User $user){

        return $user->dislikes()->toggle($post->id);
    }

    public function upvotePost(Post $post, User $user){

        return $user->upvote()->toggle($post->id);
    }

    public function downvotePost(Post $post, User $user){

        return $user->downvote()->toggle($post->id);
    }

    public function comment(Request $request, Post $post, User $user){
        
        

        $data = $request->validate([
            'comment' => 'required|string|max:800',
        ]);
        $data['user_id'] = $user->id;
        $data['post_id'] = $post->id;

            // return $data;
        if(Comment::create($data)){
            return response()->json([
                'comments' => $post->comments()->latest()->get(),

            ], 200);
        }
    }

    public function getComments(Post $post){
        return response()->json(['res' => $post->comments], 200);
    }

    public function post_report(Request $request, Post $post, User $user){
      
        return $post->postReport()->attach($user->id);
    }

    public function post_save(Request $request, Post $post, User $user){
      
        return $post->postSave()->toggle($user->id);
    }

}