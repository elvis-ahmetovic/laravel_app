<?php

namespace App\Http\Controllers\USer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;

class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }

    /* 
     * Create a new review 
     */
    public function create(Request $request, $params)
    {
        $this->validate($request, [
            'rewiev' => 'required|min:25',
        ]);

        $rewiev = new Review;
        $rewiev->user_id_send = Auth::user()->id;
        $rewiev->user_id_receive = $request->input('user_id_receive');
        $rewiev->coach_id = $request->input('coach_id');
        $rewiev->text = strtolower($request->input('rewiev'));
        $rewiev->save();

        return redirect()->to('coach/public/' . $request->input('coach_id') . '/' . $params)->with('success', 'Review succassfully added');
    }
}
