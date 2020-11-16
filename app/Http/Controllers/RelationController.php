<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware(['auth', 'user_coach']);
    }
    
    /* 
     * Make request for the first time 
     */
    public function relation_request($user_id, $coach_id, $params)
    {
        $relation = new Relation;
        $relation ->user_id_send = Auth::user()->id;
        $relation ->user_id_receive = $user_id;
        $relation ->coach_id = $coach_id;
        $relation ->save();

        return redirect()->to('coach/public/' . $coach_id . '/' . $params)->with('success', 'Request succassfully sent');
    }

    /* 
     * Cancel request 
     */
    public function cancel_request($relation_id, $coach_id, $params)
    {
        $relation = Relation::find($relation_id);
        $relation->canceled = Auth::user()->id;
        $relation ->save();

        /* If user take cancel action */
        if(Auth::user()->role === 'user')
        {
            /* If $params is "u" that means 
            that cancel request came from user/home page 
            and redirect should be on that page after action */
            if($params === 'u')
                return redirect()->to('user/home')->with('success', 'Request is canceled');

            /* Else action is taken on coach/public profile page */
            else
                return redirect()->to('coach/public/' . $coach_id . '/' . $params)->with('success', 'Request is canceled');
        }
        /* If coach take cancel action 
        that came from coach/home page 
        and redirect them on that page */
        else
            return redirect()->to('coach/home')->with('success', 'Request is canceled');
    }

    /* 
     * After cancel user can restor request 
     */
    public function restore_request($relation_id, $coach_id, $params)
    {
        $relation = Relation::find($relation_id);

        if($relation->canceled !== NULL)
            $relation->canceled = NULL;
        
        if($relation->finished !== NULL)
            $this->relation_request(Auth::user()->id, $coach_id, $params);

        $relation->save();

        return redirect()->to('coach/public/' . $coach_id . '/' . $params)->with('success', 'Request succassfully sent');
    }

    /* 
     * Finish Active Relation 
     */
    public function finish_relation($relation_id, $coach_id, $params)
    {
        $relation = Relation::find($relation_id);
        $relation->active = NULL;
        $relation->finished = 1;
        $relation->finished_at = date('Y-m-d H:i:s');;
        $relation->save();

        /* If user take cancel action */
        if(Auth::user()->role === 'user')
        {
            /* If $params is "u" that means 
            that cancel request came from user/home page 
            and redirect should be on that page after action */
            if($params === 'u')
                return redirect()->to('user/home')->with('success', 'Relation is finish');

            /* Else action is taken on coach/public profile page */
            else
                return redirect()->to('coach/public/' . $coach_id . '/' . $params)->with('success', 'Relation is finish');   
        }  
        /* If coach take cancel action 
        that came from coach/home page 
        and redirect them on that page */       
        else
            return redirect()->to('coach/home')->with('success', 'Relation is finish');
    }

    /* 
     * Accept Relation 
     */
    public function accept_relation($relation_id)
    {
         $relation = Relation::find($relation_id);
         $relation->active = 1;
         $relation->activated_at = date('Y-m-d H:i:s');
         $relation->save();

         return redirect()->to('coach/home/')->with('success', 'Relation is active');
    }

    /* 
     * Show Sender's Information 
     */
    public function senders_info($relation_id, $param)
    {
        $sender_info = DB::table('relations')
                    ->join('users', 'relations.user_id_send', '=', 'users.id')
                    ->where('relations.id', '=', $relation_id)
                    ->select('relations.*', 'relations.id as relations_id', 'users.*')
                    ->first();

        return view('coach/relations/sender')->with([
            'sender' => $sender_info,
            'param' => $param
        ]);
    }

    /* 
     * Display all active relations 
     */
    public function active_relations()
    {
        $active_relations = DB::table('relations')
                    ->join('users', 'relations.user_id_send', '=', 'users.id')
                    ->where('relations.user_id_receive', '=', Auth::user()->id)
                    ->where('relations.canceled', '=', NULL)
                    ->where('relations.active', '=', 1) 
                    ->where('relations.finished', '=', NULL) 
                    ->where('relations.deleted', '=', NULL) 
                    ->select('relations.*', 'relations.id as relations_id', 'users.*')
                    ->orderBy('relations.created_at', 'desc')
                    ->get();

        return view('coach/relations/active')->with('active_relations', $active_relations);
    }

    /* 
     * Display all finished relations 
     */
    public function finished_relations()
    {
        $finished_relations = DB::table('relations')
                    ->join('users', 'relations.user_id_send', '=', 'users.id')
                    ->where('relations.user_id_receive', '=', Auth::user()->id)
                    ->where('relations.finished', '=', 1) 
                    ->where('relations.deleted', '=', NULL)
                    ->select('relations.*', 'relations.id as relations_id', 'users.*')
                    ->orderBy('relations.created_at', 'desc')
                    ->get();

        return view('coach/relations/finished')->with('finished_relations', $finished_relations);
    }
}
