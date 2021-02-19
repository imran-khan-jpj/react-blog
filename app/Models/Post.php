<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Comment;
use Category;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'category_id', 'user_id'];
    public function comments(){
    	return $this->hasMany(Comment::class);
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function likesBy(){
    	return $this->belongsToMany(User::class, 'likes_posts_pivot');
    }

    public function dislikesBy(){
        return $this->belongsToMany(User::class, 'dislikes_posts_pivot');
    }
    public function reportBy(){
        return $this->belongsToMany(User::class, 'post_report_pivot');
    }
    public function upvoteBy(){
        return $this->belongsToMany(User::class, 'post_upvotes_pivot');
    }
    public function downvoteBy(){
        return $this->belongsToMany(User::class, 'post_downvotes_pivot');
    }
}
