<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    /* 
     * Show contact page 
     */
    public function show()
    {
        return view('contact');
    }
    
    /* 
     * Store data from contact 
     */
    public function storeData(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'message' => ['required'],
        ]);

        $contact = Contact::create([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'message' => $request->input('message')
        ]);

        return redirect()->route('contact')->with('success', 'Your message was succassfully sent.');
    }
}
