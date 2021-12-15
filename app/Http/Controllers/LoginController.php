<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');
        if(Auth::attempt(['username' => $username, 'password' => $password]))
        {
            $request->session()->regenerate();
            return [
                'login' => true
            ];
        }
        else
        {
            return [
                'login' => false,
                'username' => $username , 
                'password' => $password
            ];
        }
    }

    public function singup(Request $request) {
        if(User::where('username' , $request->input('username'))->first() == null) {
            $user = User::create([
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password'))
            ]);
            Auth::loginUsingId($user->id);
        }else {
            return [
                'err' => 'username exists'
            ];
        }
        
    }

}
