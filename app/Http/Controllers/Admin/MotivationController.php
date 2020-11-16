<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MotivationMessages;

class MotivationController extends Controller
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
    * Show motivation messages page
    */
    public function index()
    {
        $mot_msgs = MotivationMessages::where('deleted', NULL)
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(5);

        return view('admin/mot-msgs')->with('mot_msgs', $mot_msgs);
    }

    /*
     * Add new motivation message
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $mot_msg = new MotivationMessages;
        $mot_msg->title = strtolower($request->input('title'));
        $mot_msg->body = strtolower($request->input('body'));
        $mot_msg->save();

        return redirect()->to('admin/mot-msgs')->with('success', 'Succassfully added new motivation message');
    }

    /*
     * Edit message
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'new-title' => 'required',
            'new-body' => 'required'
        ]);

        $msg = MotivationMessages::find($id);
        $msg->title = strtolower($request->input('new-title'));
        $msg->body = strtolower($request->input('new-body'));
        $msg->save();

        return redirect()->to('admin/mot-msgs')->with('success', 'Message was succassfully edited');
    }

    /*
     * Delete message
     */
    public function delete($id)
    {
        $msg = MotivationMessages::find($id);
        $msg->deleted = 1;
        $msg->save();

        return redirect()->to('admin/mot-msgs')->with('success', 'Message was succassfully deleted');;
    }
}
