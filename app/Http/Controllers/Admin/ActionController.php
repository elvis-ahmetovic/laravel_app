<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Routing\UrlGenerator;

class ActionController extends Controller
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
     * Set admin.
     */
    public function setAdmin($id)
    {
        /* User */
        $user = User::find($id);

        if($user->admin_status === NULL)
            $user->admin_status = 1;
        else
            $user->admin_status = NULL;

        $user->save();

        return redirect()->to(url()->previous());
    }

    /*
     * Ban user
     */
    public function banUser($id)
    {
        $user = User::find($id);
        
        if($user->banned === NULL)
            $user->banned = 1;
        else
            $user->banned = NULL;

        $user->save();

        return redirect()->to(url()->previous());
    }
}
