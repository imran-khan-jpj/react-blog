<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        if(Auth::attempt($request->only('email', 'password'))){
            return response()->json(['res' => 'success', 'user' => User::where('email', $request->email)->first()], 200);
        }else{
            return response()->json(['message' => 'These Credentials does not match our record'], 422);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        // if($user->tokens()->delete()){
        //  return response()->json(['res' => 'logouted'], 200);   
        // }
       
        return response()->json(['res' => $user->tokens], 200);
        // $user->tokens()->where('id', $id)->delete();
        // Auth::logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        //     return response()->json(['res' => 'loggedOut'], 200);
    }


}
