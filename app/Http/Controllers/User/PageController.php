<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
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
        $this->middleware(['auth', 'user'])->except('logout');
    }
    
    /* 
     * Get all informations on user's homepage 
     */
    public function index()
    {
        /* Get all requests in proces */
        $relation_requests = DB::table('relations')
                    ->join('users', 'relations.user_id_receive', '=', 'users.id')
                    ->where('relations.user_id_send', '=', Auth::user()->id)
                    ->where('relations.canceled', '=', NULL)
                    ->where('relations.active', '=', NULL) 
                    ->where('relations.finished', '=', NULL) 
                    ->where('relations.deleted', '=', NULL) 
                    ->select('relations.*', 'relations.id as relations_id', 'users.*')
                    ->orderBy('relations.created_at', 'desc')
                    ->get();

        /* Get all active relations */
        $active_relations = DB::table('relations')
                    ->join('users', 'relations.user_id_receive', '=', 'users.id')
                    ->where('relations.user_id_send', '=', Auth::user()->id)
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
                    ->join('users', 'relations.user_id_receive', '=', 'users.id')
                    ->where('relations.user_id_send', '=', Auth::user()->id)
                    ->where('relations.finished', '=', 1) 
                    ->where('relations.deleted', '=', NULL)
                    ->select('relations.*', 'relations.id as relations_id', 'users.*')
                    ->orderBy('relations.created_at', 'desc')
                    ->limit(3)
                    ->get();

        /* Get all reviews */
        $reviews = DB::table('reviews')
                    ->join('users', 'reviews.user_id_receive', '=', 'users.id')
                    ->where('reviews.user_id_send', '=', Auth::user()->id)
                    ->orderBy('reviews.created_at', 'desc')
                    ->limit(3)
                    ->get();
            
        $notes = Note::where('user_id', Auth::user()->id)
                        ->where('deleted', NULL)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();

        return view('user/home')->with([
            'relation_requests' => $relation_requests,
            'active_relations' => $active_relations,
            'finished_relations' => $finished_relations,
            'reviews' => $reviews,
            'notes' => $notes
        ]);
    }

    /*
     *  Show profile
     */
    public function profile()
    {
        $user = DB::table('users')
                    ->where('users.id', '=', Auth::user()->id)
                    ->first();

        return view('user/profile')->with('user', $user);
    }
}
