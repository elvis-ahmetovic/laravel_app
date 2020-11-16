<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class CityController extends Controller
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
     * Show change city page 
     */
    public function index()
    {
        /* User */
        $user = User::where('id', Auth::user()->id)->first();
        
        return view('profile/city')->with('user', $user);;
    }

    /* 
     * Change city 
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'new-city' => 'required|min:4'
        ]);

        $user = User::find($id);
        $user->city = strtolower($request->input('new-city'));
        $user->save();

        return redirect()->to('/profile')->with('success', 'City succassfully saved');
    }
}
