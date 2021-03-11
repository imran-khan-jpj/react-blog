<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('welcome'); });
// dd('we are here');
// Auth::routes();
Route::post('/login', [LoginController::class, 'login']);
// Route::middleware('auth:sanctum')->group(function(){
// 	Route::post('/logout', [LoginController::class, 'logout']);
// });
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });