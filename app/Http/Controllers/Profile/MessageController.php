<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Coach;

class MessageController extends Controller
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
     * Show change motivation message title page 
     */
    public function title()
    {
        /* User (coach) */
        $user = DB::table('coaches')
                    ->join('users', 'coaches.user_id', '=', 'users.id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->select('coaches.*', 'coaches.id as coach_id', 'users.*')
                    ->first();
        
        return view('profile/msg-title')->with('user', $user);;
    }

    /* 
     * Show change motivation message body page 
     */
    public function body()
    {
        /* User (coach) */
        $user = DB::table('coaches')
                    ->join('users', 'coaches.user_id', '=', 'users.id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->select('coaches.*', 'coaches.id as coach_id', 'users.*')
                    ->first();
        
        return view('profile/msg-body')->with('user', $user);;
    }

    /* 
     * Change motivation message title 
     */
    public function edit_title(Request $request, $id)
    {
        $this->validate($request, [
            'new-title' => 'required|min:4'
        ]);

        $user = Coach::where('user_id', Auth::user()->id)->first();
        $user->msg_title = $request->input('new-title');
        $user->save();

        return redirect()->to('/profile')->with('success', 'Message title succassfully saved');
    }

    /* 
     * Change motivation message body 
     */
    public function edit_body(Request $request, $id)
    {
        $this->validate($request, [
            'new-body' => 'required'
        ]);

        $user = Coach::where('user_id', Auth::user()->id)->first();
        $user->msg_body = $request->input('new-body');
        $user->save();

        return redirect()->to('/profile')->with('success', 'Message body succassfully saved');
    }
}
