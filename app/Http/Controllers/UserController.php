<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['users' => User::all()], 200);
    }

    public function show(User $user){
        return response()->json(['message' => 'success', 'user' => $user], 200);
    }
    public function store(Request $request){
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:3|max:30',
        ]);
        
            // dd($data);
        $data['password'] = bcrypt($data['password']);

        if($user = User::create($data)){
            return response()->json(['message' => 'success', 'user' => $user], 200);
        }
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|min:3|max:30',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|confirmed',
        ]);

        if($user->update($data)){
            return response()->json(['message' => 'success', 'user' => $user], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()){
            return response()->json(['message' => 'success'], 200);
        }
    }

    public function savePost(Request $request){
        return $user->savePost()->attach($post->id);
    }
}
