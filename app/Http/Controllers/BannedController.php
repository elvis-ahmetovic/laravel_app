<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BannedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'banned']);
    }

    public function banned()
    {
        return view('banned');
    }
}
