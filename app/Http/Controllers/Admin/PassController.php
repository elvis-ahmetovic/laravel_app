<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class PassController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    
    /*
    * Show change password page
    */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        
        return view('admin/password')->with('user', $user);
    }

    /*
    * Change password
    */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|password',
            'new-password' => 'required|min:4',
            'confirm-password' => 'required|same:new-password',
        ]);

        $user = User::find($id);
        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        return redirect()->to('admin/password')->with('success', 'Password succassfully saved');
    }
}
