<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
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
    * Show users page
    */
    public function index()
    {
        $users = User::where('username', '!=', 'admin')
                    ->where('role', '!=', 'verified_coach')
                    ->paginate(10);

        return view('admin/users')->with('users', $users);
    }
}
