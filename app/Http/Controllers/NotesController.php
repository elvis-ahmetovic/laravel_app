<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Note;

class NotesController extends Controller
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
     * Insert note
     */
    public function store_note(Request $request, $param)
    {
        $this->validate($request, [
            'note' => 'required',
        ]);

        $note = new Note;
        $note->user_id = Auth::user()->id;
        $note->note = $request->input('note');
        $note->save();

        if($param === 'u')
            return redirect()->to('user/home')->with('success', 'Note was succassfully created');
        elseif($param === 'c')
            return redirect()->to('coach/home')->with('success', 'Note was succassfully created');
        else
            return redirect()->to('/notes')->with('success', 'Note was succassfully created');
    }

    /*
     * Show notes on notes page
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth::user()->id)
                        ->where('deleted', NULL)
                        ->orderBy('created_at', 'desc')
                        ->paginate(8);

        return view('notes')->with('notes', $notes);
    }

    /*
     * Edit note
     */
    public function edit_note(Request $request, $id, $param)
    {
        $this->validate($request, [
            'new-note' => 'required',
        ]);

        $note = Note::find($id);
        $note->note = strtolower($request->input('new-note'));
        $note->save();

        if($param === 'u')
            return redirect()->to('user/home')->with('success', 'Note was succassfully edited');
        elseif($param === 'c')
            return redirect()->to('coach/home')->with('success', 'Note was succassfully edited');
        else
            return redirect()->to('/notes')->with('success', 'Note was succassfully edited');
    }

    /*
     * Finish/unfinish note
     */
    public function finish_note($id, $param)
    {
        $note = Note::find($id);
        if($note->finished === NULL)
            $note->finished = 1;
        else
            $note->finished = NULL;

        $note->save();

        if($param === 'u')
            return redirect()->to('user/home');
        elseif($param === 'c')
            return redirect()->to('coach/home');
        else
            return redirect()->to('/notes');
    }

    /*
     * Delete note
     */
    public function delete_note($id, $param)
    {
        $note = Note::find($id);
        if($note->deleted === NULL)
            $note->deleted = 1;
        else
            $note->deleted = NULL;

        $note->save();

        if($param === 'u')
            return redirect()->to('user/home')->with('success', 'Note was succassfully deleted');
        elseif($param === 'c')
            return redirect()->to('coach/home')->with('success', 'Note was succassfully deleted');
        else
            return redirect()->to('/notes')->with('success', 'Note was succassfully deleted');
    }
}
