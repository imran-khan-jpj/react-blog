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
        // $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        if(auth()->check()){
            Auth::guard('web')->logout();
            if(Auth::attempt($request->only('email', 'password'))){
                return response()->json(['res' => 'success', 'user' => User::where('email', $request->email)->first()], 200);
            }
        }


        if(Auth::attempt($request->only('email', 'password'))){
            return response()->json(['res' => 'success', 'user' => User::where('email', $request->email)->first()], 200);
        }else{
            return response()->json(['message' => 'These Credentials does not match our record'], 422);
        }
    }

    public function logout(Request $request)
    {
        // dd('inside of logout method');
        Auth::guard('web')->logout();

        return response()->json(['res' => 'success'], 200);
        
    }


}
