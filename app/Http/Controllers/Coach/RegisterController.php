<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Coach;
use App\Category;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'unverified'])->except(['logout', 'index', 'public']);
    }

    /*
     *  Show finish registration form
     */
    public function showFinishRegistration()
    {
        /* User */
        $user = User::find(auth()->id());

        /* Categories */
        $categories = Category::where('disabled', NULL)->where('deleted', NULL)->get();
        
        return view('coach/finish')->with([
            'user' => $user,
            'categories' => $categories
        ]);
    }

    /*
     *  Store data from finish registration
     */
    public function storeFinishRegistration(Request $request)
    {
        $request->validate([
            'category_id' => ['required'],
            'price' => ['required', 'numeric'],
            'phone' => ['required', 'numeric', 'min:9'],
            'msg_title' => ['required', 'min:4'],
            'msg_body' => ['required'],
        ]);

        $coach = Coach::create([
            'user_id' => $request->input('user_id'),
            'category_id' => $request->input('category_id'),
            'price' => $request->input('price'),
            'phone' => $request->input('phone'),
            'msg_title' => $request->input('msg_title'),
            'msg_body' => $request->input('msg_body'),
        ]);

        $user = User::find($request->input('user_id'));
        $user->role = 'verified_coach';
        $user->save();

        return redirect()->route('coach-home');
    }
}
