<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    //protected $redirectTo = '/coach/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // If User is Banned
        if($user->isBanned()) 
            return redirect(route('banned'));

        // If is Coach
        if($user->isCoach()) 
            return redirect(route('show-finish-registration'));

        // If is Verified Coach
        if($user->isVerifiedCoach()) 
            return redirect(route('coach-home'));
        

        // If is User
        if($user->isUser()) 
            return redirect(route('user-home'));

        // If is Super Administrator
        if($user->isSuperadmin()) 
            return redirect(route('superadmin-home'));

        abort(404);
    }
}
