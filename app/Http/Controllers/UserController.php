<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request){
        $in = $request->validate([
            'name' => ['required', 'min:3', 'max:20'], 
            'email' => ['required', 'email'], 
            'password' => ['required', 'min:8', 'max:200'], 
        ]);
        $in['password'] = bcrypt($in['password']);
        $user = User::create($in);
        auth() -> login($user);
        return redirect('/home');
    }


    public function login(Request $request){
        $in = $request->validate([
            'lemail' => ['required'], 
            'lpassword' => ['required'], 
        ]);
        if(auth()->attempt(['email' => $in['lemail'], 'password' => $in['lpassword']])){
            $request->session()->regenerate();
        }
        return redirect('/home');
    }


    public function logout(Request $request){
        auth() -> logout();
        return redirect('/home');
    }
}
