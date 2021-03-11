<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'user_id', 'post_id'];

    public function post(){
    	return $this->belongsTo(Post::class);
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function commentLikeBy(){
        return $this->belongsToMany(User::class, 'comment_like_pivot');
    }

    public function commentDisikeBy(){
        return $this->belongsToMany(User::class, 'comment_like_pivot');
    }
}
