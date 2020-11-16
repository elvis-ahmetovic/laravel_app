<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Relation;

class RelationController extends Controller
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
    * Show relation page
    */
    public function index()
    {
        $relations = DB::table('relations')
                        ->join('users AS u1', 'relations.user_id_send', 'u1.id')
                        ->join('users AS u2', 'relations.user_id_receive', 'u2.id')
                        ->join('coaches', 'relations.coach_id', 'coaches.id')
                        ->join('categories', 'coaches.category_id', 'categories.id')
                        ->select('relations.*', 'relations.activated_at AS started_at', 'relations.finished_at AS finished_at', 'u1.name AS send_name', 'u1.lastname AS send_lastname', 'u2.name AS receive_name', 'u2.lastname AS receive_lastname', 'u2.city AS receive_city', 'categories.name AS cat_name')
                        ->orderBy('relations.created_at', 'desc')
                        ->paginate(10);

        return view('admin/relations')->with('relations', $relations);
    }

    /*
    * Show active relation page
    */
    public function active_relations()
    {
        $active_relations = DB::table('relations')
                        ->join('users AS u1', 'relations.user_id_send', 'u1.id')
                        ->join('users AS u2', 'relations.user_id_receive', 'u2.id')
                        ->join('coaches', 'relations.coach_id', 'coaches.id')
                        ->join('categories', 'coaches.category_id', 'categories.id')
                        ->select('relations.*', 'relations.activated_at AS started_at', 'relations.finished_at AS finished_at', 'u1.name AS send_name', 'u1.lastname AS send_lastname', 'u2.name AS receive_name', 'u2.lastname AS receive_lastname', 'u2.city AS receive_city', 'categories.name AS cat_name')
                        ->where('relations.active', 1)
                        ->orderBy('relations.created_at', 'desc')
                        ->paginate(10);

        return view('admin/active-relations')->with('active_relations', $active_relations);
    }
}
