<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/setup', function(){
//     $credentials = [
//         'email' => 'admin@mail.com',
//         'password' => 'password'
//     ];

//     if(!Auth::attempt($credentials)){
//         $user = new User();

//         $user->name = 'Admin';
//         $user->email = 'admin@mail.com';
//         $user->password = Hash::make($credentials['password']);

//         $user->save();
//     }

//     if(Auth::attempt($credentials)){
//         // $user = Auth::user();

//         // $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
//         // $updateToken = $user->createToken('update-token', ['create', 'update']);
//         // $basicToken = $user->createToken('basic-token');
        

//         return [

//         ];
//     }
// });
