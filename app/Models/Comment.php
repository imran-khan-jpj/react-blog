<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Post;
use Category;
class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment_details'];

    public function post(){
    	return $this->blongsTo(Post::class);
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }
}
