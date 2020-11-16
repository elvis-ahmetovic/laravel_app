<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;

class ImageController extends Controller
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
     * Show change image page 
     */
    public function index()
    {
        /* User */
        $user = User::where('id', Auth::user()->id)->first();
        
        return view('profile/image')->with('user', $user);;
    }

    /* 
     * Change image 
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'new-image' => 'required|image'
        ]);

        $user = User::find($id);

        Storage::delete('public/avatars/' . $user->image);
        
        // Get Original Image Name With Extension
        $filenameWithExtension = $request->file('new-image')->getClientOriginalName();
        // Get Only Image Name Without Extension
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
        // Get Image Extension
        $extension = $request->file('new-image')->getClientOriginalExtension();
        // Create Nane For Store (Adding timestamps between name and extension)
        $filenameToStore = $filename . '_' . time() . '.' . $extension;
        
        $user->image = $filenameToStore;
        $user->save();

        // Store the Image
        $path = $request->file('new-image')->storeAs('public/avatars/', $filenameToStore);

        return redirect('/profile')->with('success', 'Image successfully saved');
    }
}
