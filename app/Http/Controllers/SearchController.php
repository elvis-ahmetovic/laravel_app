<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coach;
use App\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class SearchController extends Controller
{
    /* 
     * Search Method 
     */
    public function search(Request $request)
    {
        /* Get all coaches */
        $coaches = Coach::with(['user', 'category'])->get();

        if($request->has('city') && !empty($request->city))
            $coaches = $coaches->where('user.city', strtolower($request->city)); 

        if($request->has('category') && !empty($request->category))
            $coaches = $coaches->where('category.name', strtolower($request->category));     

        if($request->has('lowprice') && !empty($request->lowprice))
            $coaches = $coaches->where('price', '>', $request->lowprice);     

        if($request->has('highprice') && !empty($request->highprice))
            $coaches = $coaches->where('price', '<', $request->highprice); 

        /* Get relations */
        $relations = Relation::get();

        $url = url()->full(); // Current url
        $params = explode('?', $url); // Explode url
        $params = $params[1]; // Search parameters
        

        return view('search')->with([
            'coaches' => $coaches,
            'relations' => $relations,
            'params' => $params
        ]); 
    }
}
