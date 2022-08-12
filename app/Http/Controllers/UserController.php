<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
           'email' => 'required|email',
           'password' => 'required'
        ]);


        if ($validator->fails()){
            return redirect('/login')->withErrors($validator->errors());
        }

        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember == "on";


        if (auth()->attempt(['email' => $email, 'password' => $password], $remember)){
            return redirect('/');
        } else {
            return redirect('/login')->withErrors(['msg' => 'Invalid credentials']);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);


        if ($validator->fails()){
            return redirect('/register')->withErrors($validator->errors());
        }

        $name = $request->name;
        $password = $request->password;
        $email = $request->email;

        User::create([
            'id' => Str::uuid(),
            'name' => $name,
            'password' => bcrypt($password),
            'email' => $email,
            'role' => 'user',
        ]);

        return redirect('/login');
    }

    public function logout(Request $request){
        auth()->logout();
        return redirect('/');
    }

    public function login_index(Request $request){
        if (auth()->check()) return redirect('/');
        return view('login');
    }

    public function register_index(Request $request){
        if (auth()->check()) return redirect('/');
        return view('register');
    }
}
