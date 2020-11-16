<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user_coach']);
    }
    
    /*
     *  Show profile
     */
    public function profile()
    { 
        /* If user role is 'user' */
        if(Auth::user()->role === 'user')
        {
            /* User */
            $user = DB::table('users')
                ->where('users.id', '=', Auth::user()->id)
                ->select('users.*', 'users.name as users_name', 'users.id as user_id')
                ->first();
        }
        else
        {
            /* User (coach) */
            $user = DB::table('coaches')
                    ->join('users', 'coaches.user_id', '=', 'users.id')
                    ->join('categories', 'coaches.category_id', '=', 'categories.id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->select('coaches.*', 'coaches.id as coach_id', 'users.*', 'users.name as users_name', 'categories.*', 'categories.name as category_name')
                    ->first();
        }

        return view('/profile/profile')->with('user', $user);
    }
}
