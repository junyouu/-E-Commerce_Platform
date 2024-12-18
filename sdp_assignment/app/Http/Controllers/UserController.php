<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(){
        return view('index');
    }

    public function register(Request $request){
        $data = $request->validate([
            'username' => 'required|string|max:16|unique:users,username', 
            'password' => 'required|string|min:8|max:16|regex:/[a-zA-z]/|regex:/[0-9]/',
            'role' => 'required'
        ]);

        $data['password'] = Hash::make($data['password']);
        $newUser = User::create($data);
        Auth::login($newUser);

        if ($data['role'] === 'customer'){
            return redirect(route('customer.complete_profile_form'));
        } elseif ($data['role'] === 'seller'){
            return redirect(route('seller.complete_profile_form'));
        }
    }

    public function show_login_form(){
        return view('login');
    }


    public function login(Request $request){
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();

            if($user->is_suspended == true){
                return redirect()->back()->withErrors(['login' => 'Your account has been suspended. Please contact admin for more information.']);
            }
            
            if ($user->role === 'customer') {
                return redirect()->intended(route('customer.index'));
            } elseif ($user->role === 'seller') {
                return redirect()->intended(route('seller.index'));
            } elseif ($user->role === 'admin') {
                return redirect()->intended(route('admin.index'));
            }
        }

        return redirect()->back()->withErrors(['login' => 'Invalid credentials.']);
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('user.show_login_form');
    }
}
