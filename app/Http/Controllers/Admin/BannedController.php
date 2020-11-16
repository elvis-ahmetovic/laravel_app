<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class BannedController extends Controller
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
     * Show banned users page
    */
    public function index()
    {
        /* Users */
        $users = User::where('banned', 1)->paginate(10);

        return view('admin/banned')->with('users', $users);
    }
}
