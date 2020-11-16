<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Coach;
use App\Relation;
use App\Review;

class HomeController extends Controller
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
     * Show admin's homepage (dashboard)
     */
    public function index()
    {
        // Number of All Users Without Admin
        $all_users = User::count()-1;
        // Number of Regular Users
        $regular_users = User::where('role', 'user')->count();
        // Number of Verified Coaches
        $verified_coaches = User::where('role', 'verified_coach')->count();
        // Number of Unverified Coaches
        $unverified_coaches = User::where('role', 'coach')->count();
        // Number of Categories
        $categories = Category::count();
        // Number of Relations
        $relations = Relation::count();
        // Number ofActive relations
        $active_relations = Relation::where('active', 1)->count();
        // Number of Reviews
        $reviews = Review::count();

        // Most Used Category
        $most_used = DB::table('coaches')
                        ->join('categories', 'category_id', '=', 'categories.id')
                        ->select('category_id', DB::raw('COUNT(category_id) AS num'), 'categories.name')
                        ->groupBy('category_id')
                        ->groupBy('categories.name')
                        ->orderBy('num', 'desc')
                        ->first();

        // Least Used Category
        $least_used = DB::table('coaches')
                        ->join('categories', 'category_id', '=', 'categories.id')
                        ->select('category_id', DB::raw('COUNT(category_id) AS num'), 'categories.name')
                        ->groupBy('category_id')
                        ->groupBy('categories.name')
                        ->orderBy('num', 'asc')
                        ->first();

        // Coach with most relations
        $most_relations = DB::table('relations')
                            ->join('users', 'relations.user_id_receive', 'users.id')
                            ->select('user_id_receive', DB::raw('COUNT(user_id_receive) AS num'), 'users.name')
                            ->groupBy('user_id_receive')
                            ->groupBy('users.name')
                            ->orderBy('num', 'asc')
                            ->first();

        // User with most reviews
        $most_reviews = DB::table('reviews')
                            ->join('users', 'reviews.user_id_receive', 'users.id')
                            ->select('user_id_receive', DB::raw('COUNT(user_id_receive) AS num'), 'users.name')
                            ->groupBy('user_id_receive')
                            ->groupBy('users.name')
                            ->orderBy('num', 'asc')
                            ->first();

        $data = [
            'all_users' => $all_users,
            'regular_users' => $regular_users,
            'verified_coaches' => $verified_coaches,
            'unverified_coaches' => $unverified_coaches,

            'categories' => $categories,
            'most_used' => $most_used,
            'least_used' => $least_used,

            'relations' => $relations,
            'active_relations' => $active_relations,
            'most_relations' => $most_relations,

            'reviews' => $reviews,
            'most_reviews' => $most_reviews
        ];

        return view ('admin/home')->with('data', $data);
    }
}
