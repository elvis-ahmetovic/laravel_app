<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'city' => ['required', 'string', 'min:4'],
            'image' => ['required', 'image'],
            'role' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $request = app('request');

        // Get Original Image Name With Extension
        $filenameWithExtension = $request->file('image')->getClientOriginalName();
        // Get Only Image Name Without Extension
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
        // Get Image Extension
        $extension = $request->file('image')->getClientOriginalExtension();
        // Create Nane For Store (Adding timestamps between name and extension)
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        $user = User::create([
            'name' => strtolower($data['name']),
            'lastname' => strtolower($data['lastname']),
            'username' => strtolower($data['username']),
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
            'city' => strtolower($data['city']),
            'image' => $filenameToStore,
            'role' => $data['role'],
        ]);

        // Store the Image
        $path = $request->file('image')->storeAs('public/avatars/', $filenameToStore);

            session()->flash('status', 'You are seuccassfully registered. Now you can sign in.');
            
            return redirect()->route('login');
    }
}
