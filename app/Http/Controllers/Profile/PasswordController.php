<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class PasswordController extends Controller
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
     * Show change password page 
     */
    public function index()
    {
        /* User */
        $user = User::where('id', Auth::user()->id)->first();
        
        return view('profile/password')->with('user', $user);;
    }

    /* 
     * Change password 
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|password',
            'new-password' => 'required|min:4',
            're-new-password' => 'required|same:new-password',
        ]);

        $user = User::find($id);
        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        return redirect()->to('/profile')->with('success', 'Password succassfully saved');
    }
}
