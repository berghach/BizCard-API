<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ContactController;
use Illuminate\Validation\ValidationException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        // 'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken('admin-token', ['create', 'update', 'delete'])->plainTextToken;
});


Route::apiResource('cards', CardController::class)->middleware('auth:sanctum');
Route::apiResource('contacts', ContactController::class)->middleware('auth:sanctum');
Route::apiResource('links', LinkController::class)->middleware('auth:sanctum');