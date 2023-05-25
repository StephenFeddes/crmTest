<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function show()
    {
        if(auth()->user()) {
            return redirect('/dashboard');
        }
        return view('welcome');
    }

    public function login()
    {
        validator(request()->all(), [
            'username'=>['required'],
            'password'=>['required']
        ])->validate();

        if(auth()->attempt(request()->only(['username', 'password']))) {
            return redirect('/dashboard');
        }

        return redirect()->back()->withErrors(['username'=>'Invalid Credentials!']);
    }

    public function logout() {
        auth()->logout();

        return redirect('/');
    }
}
