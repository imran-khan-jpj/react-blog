<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'category_id', 'user_id', 'image'];
    public function comments(){
        // dd(Comment::class);
    	return $this->hasMany(Comment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
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
        return $this->belongsToMany(User::class, 'downvotes_post_pivot');
    }

    public function postReport(){
        return $this->belongsToMany(User::class, 'post_report_pivot');
    }

    public function postSave(){
        return $this->belongsToMany(User::class, 'post_save_pivot');
    }

    
}
