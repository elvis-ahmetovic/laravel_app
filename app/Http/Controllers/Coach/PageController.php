<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Coach;
use App\Category;
use App\MotivationMessages;
use App\Relation;
use App\Review;
use App\Note;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified_coach'])->except(['logout', 'public']);
    }

    

    /*
     *  Home
     */
    public function home()
    {
        /* Get all relation requests for particular user (coach) */
        $relation_requests = DB::table('relations')
                    ->join('users', 'relations.user_id_send', '=', 'users.id')
                    ->where('relations.user_id_receive', '=', Auth::user()->id)
                    ->where('relations.canceled', '=', NULL)
                    ->where('relations.active', '=', NULL) 
                    ->where('relations.finished', '=', NULL) 
                    ->where('relations.deleted', '=', NULL) 
                    ->select('relations.*', 'relations.id as relations_id', 'users.*')
                    ->orderBy('relations.created_at', 'desc')
                    ->get();

        /* Get all active relations */
        $active_relations = DB::table('relations')
                    ->join('users', 'relations.user_id_send', '=', 'users.id')
                    ->where('relations.user_id_receive', '=', Auth::user()->id)
                    ->where('relations.canceled', '=', NULL)
                    ->where('relations.active', '=', 1) 
                    ->where('relations.finished', '=', NULL) 
                    ->where('relations.deleted', '=', NULL) 
                    ->select('relations.*', 'relations.id as relations_id', 'users.*')
                    ->orderBy('relations.created_at', 'desc')
                    ->limit(3)
                    ->get();

        /* Get all finished relations */
        $finished_relations = DB::table('relations')
                    ->join('users', 'relations.user_id_send', '=', 'users.id')
                    ->where('relations.user_id_receive', '=', Auth::user()->id)
                    ->where('relations.finished', '=', 1) 
                    ->where('relations.deleted', '=', NULL)
                    ->select('relations.*', 'relations.id as relations_id', 'users.*')
                    ->orderBy('relations.created_at', 'desc')
                    ->limit(3)
                    ->get();

        /* Get all reviews */
        $reviews = DB::table('reviews')
                    ->join('users', 'reviews.user_id_send', '=', 'users.id')
                    ->where('reviews.user_id_receive', '=', Auth::user()->id)
                    ->orderBy('reviews.created_at', 'desc')
                    ->limit(3)
                    ->get();

        $notes = Note::where('user_id', Auth::user()->id)
                        ->where('deleted', NULL)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();

        return view('coach/home')->with([
            'relation_requests' => $relation_requests,
            'active_relations' => $active_relations,
            'finished_relations' => $finished_relations,
            'reviews' => $reviews,
            'notes' => $notes
        ]);
    }

    /*
     *  Show public profile
     *  $params is hardcoded parameter used for 
     *  back on previous page and right redirections 
     */
    public function public($id, $params)
    {
        $user_id = (Auth::check()) ? Auth::user()->id : NULL;

        /* Finf coach by ID */
        $coach = Coach::find($id);

        /* Get all relations (active and canceled if exists) */
        $relations = Relation::where('coach_id', $id)
                            ->where('user_id_send', $user_id)
                            ->where('finished', NULL)
                            ->get();
        
        /* Get all reviews for particular coach */
        $reviews = DB::table('reviews')
                    ->join('users', 'reviews.user_id_send', '=', 'users.id')
                    ->where('reviews.coach_id', '=', $coach->id)
                    ->orderBy('reviews.created_at', 'desc')
                    ->paginate(4);

        return view('coach/public')->with([
            'coach' => $coach,
            'relations' => $relations,
            'reviews' => $reviews,
            'params' => $params
            ]);
    }

    /*
     *  Show profile
     */
    public function profile()
    {
        $coach = DB::table('coaches')
                    ->join('users', 'coaches.user_id', '=', 'users.id')
                    ->join('categories', 'coaches.category_id', '=', 'categories.id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->select('coaches.*', 'coaches.id as coach_id', 'users.*', 'users.name as users_name', 'categories.*', 'categories.name as category_name')
                    ->first();

        return view('coach/profile')->with('coach', $coach);
    }
}
