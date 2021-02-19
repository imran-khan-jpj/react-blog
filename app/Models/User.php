<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function likes(){
        return $this->belongsToMany(Post::class, 'likes_posts_pivot');
    }

    public function dislikes(){
        return $this->belongsToMany(Post::class, 'dislikes_posts_pivot');
    }
    public function report(){
        return $this->belongsToMany(Post::class, 'post_report_pivot');
    }
    public function upvote(){
        return $this->belongsToMany(Post::class, 'post_upvotes_pivot');
    }
    public function downvote(){
        return $this->belongsToMany(Post::class, 'downvotes_post_pivot');
    }
}
