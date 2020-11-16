<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Coach;
use App\Category;

class CategoryController extends Controller
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
     * Show category change page 
     */
    public function index()
    {
        /* User (coach) */
        $user = DB::table('coaches')
                    ->join('users', 'coaches.user_id', '=', 'users.id')
                    ->join('categories', 'coaches.category_id', '=', 'categories.id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->select('coaches.*', 'coaches.id as coach_id', 'users.*', 'users.name as users_name', 'categories.*', 'categories.name as category_name')
                    ->first();

        /* Categories */
        $categories = Category::all();
        
        return view('profile/category')->with([
            'user' => $user,
            'categories' => $categories
            ]);;
    }

    /* 
     * Change category 
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'new-category' => 'required'
        ]);

        $user = Coach::where('user_id', Auth::user()->id)->first();
        $user->category_id = $request->input('new-category');
        $user->save();

        return redirect()->to('/profile')->with('success', 'Catgory uccassfully saved');
    }
}
