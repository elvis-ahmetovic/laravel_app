<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CoachController extends Controller
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
     * Show coaches page
     */
    public function index()
    {
        // Coaches
        $coaches = User::whereIn('role', ['coach', 'verified_coach'])->paginate(10);

        return view('admin/coaches')->with('coaches', $coaches);
    }
}
