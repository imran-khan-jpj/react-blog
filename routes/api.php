<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Models\Comment;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// phpinfo();

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
//Unprotected Routes
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/post',     [PostController::class, 'index']);





//Protected Routes

Route::middleware('auth:sanctum')->group(function(){
	
//Logout Route	
Route::post('/logout', [LoginController::class, 'logout']);
//User Routes
Route::get('/user',                                    [UserController::class, 'index']);
Route::get('/user/{user}',                             [UserController::class, 'show']);
Route::post('/user',                                   [UserController::class, 'store']);
Route::patch('/user/{user}',                           [UserController::class, 'update']);
Route::delete('/user/{user}',                          [UserController::class, 'destroy']);
//Category Related Routes
Route::post('/category/create',                        [CategoryController::class, 'store']);
Route::get('/category/{category}',                     [CategoryController::class, 'show']);
Route::patch('/category/{category}',                   [CategoryController::class, 'update']);
Route::delete('/category/{category}',                  [CategoryController::class, 'destroy']);
// Post Related Routes
Route::post('/post/create',                            [PostController::class, 'store']);
Route::get('/post/{post}',                             [PostController::class, 'show']);
Route::patch('/post/{post}',                           [PostController::class, 'update']);
Route::delete('/post/{post}',                          [PostController::class, 'destroy']);
Route::post('/post/like/{post}/{user}',                [PostController::class, 'likePost']);
Route::post('/post/dislike/{post}/{user}',             [PostController::class, 'dislikePost']);
Route::post('/post/upvote/{post}/{user}',              [PostController::class, 'upvotePost']);
Route::post('/post/downvote/{post}/{user}',            [PostController::class, 'downvotePost']);
Route::post('/post/{post}/comment/{user}',             [PostController::class, 'comment']);
Route::get('/post/{post}/comments',                    [PostController::class, 'getComments']);
Route::post('/post/report/{post}/{user}',              [PostController::class, 'post_report']);
Route::post('/post/save/{post}/{user}',                [PostController::class, 'post_save']);
Route::post('/post/saved/{user}',                      [PostController::class, 'postSaved']);
Route::post('/post/{post}/comment/{comment}/like',     [CommentController::class, 'likeComment']);
Route::delete('post/{post}/comment/{comment}/delete',  [CommentController::class, 'destroy']);

});