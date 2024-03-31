<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!empty($user)){
            if (Hash::check($request->password, $user->password)) {
                return $user->createToken($user->name.'token', ['create', 'update', 'delete'])->plainTextToken;
            }else{
                    return ['The password is incorrect.'];
            }
        }else{
            return ['User not found', 'Sign up in /api/sanctum/signup'];
        }
    }
    public function signup(Request $request){
        $validData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($validData);
        return $user->createToken($user->name.'token', ['create', 'update', 'delete'])->plainTextToken;
    }
}
