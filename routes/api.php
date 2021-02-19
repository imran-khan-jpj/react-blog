<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
	Route::post('logout', [LoginController::class, 'logout']);
	Route::get('/user', [UserController::class, 'index']);
});

// Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
//User Routes
Route::get('/user/{user}', [UserController::class, 'show']);
Route::patch('/user/{user}', [UserController::class, 'update']);
Route::delete('/user/{user}', [UserController::class, 'delete']);
// Route::get('/category/create', [])
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category/create', [CategoryController::class, 'store']);
Route::get('/category/{category}', [CategoryController::class, 'show']);
Route::patch('/category/{category}', [CategoryController::class, 'update']);
Route::delete('/category/{category}', [CategoryController::class, 'destroy']);
// Post Related Routes
Route::get('/post', [PostController::class, 'index']);
Route::post('/post/create', [PostController::class, 'store']);
Route::get('/post/{post}', [PostController::class, 'show']);
Route::patch('/post/{post}', [PostController::class, 'update']);
Route::delete('/post/{post}', [PostController::class, 'destroy']);
Route::post('/post/like/{post}/{user}', [PostController::class, 'likePost']);
Route::post('/post/dislike/{post}/{user}', [PostController::class, 'dislikePost']);
Route::post('/post/upvote/{post}', [PostController::class, 'upvotePost']);
Route::post('/post/downvote/{post}', [PostController::class, 'downupvotePost']);