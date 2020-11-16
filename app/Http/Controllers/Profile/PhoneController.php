<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Coach;

class PhoneController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified_coach']);
    }
    
    /* 
     * Show change phone page 
     */
    public function index()
    {
        /* user (coach) */
        $user = DB::table('coaches')
                    ->join('users', 'coaches.user_id', '=', 'users.id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->select('coaches.*', 'coaches.id as coach_id', 'users.*')
                    ->first();
        
        return view('profile/phone')->with('user', $user);
    }

    /* 
     * Change phone 
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'new-phone' => 'required|numeric|min:9'
        ]);

        $user = Coach::where('user_id', Auth::user()->id)->first();
        $user->phone = $request->input('new-phone');
        $user->save();

        return redirect()->to('/profile')->with('success', 'Price succassfully saved');
    }
}
