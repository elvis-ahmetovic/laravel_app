<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\MotivationMessages;
use App\Relation;

class IndexController extends Controller
{
    /*
     *  Show index page
     */
    public function index()
    {
        /* Get 8 random coaches for index page */
        $coaches = DB::table('coaches')
                    ->join('users', 'coaches.user_id', '=', 'users.id')
                    ->join('categories', 'coaches.category_id', '=', 'categories.id')
                    ->where('users.banned', '=', NULL)
                    ->select('coaches.*', 'coaches.id as coach_id', 'users.*', 'users.name as users_name', 'categories.*', 'categories.name as category_name')
                    ->inRandomOrder()
                    ->limit(8)
                    ->get();
        
        /* Get all categories avalible for search */
        $categories = Category::where('disabled', NULL)->where('deleted', NULL)->get();

        /* Get one random motivation messsage */
        $motivation_message = MotivationMessages::all()->random(1)->first();
        
        /* Get all relations */
        $relations = Relation::get();

        return view('index')->with([
            'coaches' => $coaches,
            'categories' => $categories,
            'motivation_message' => $motivation_message,
            'relations' => $relations
            ]);
    }
}
