<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LinkController;
use App\Models\Card;

// edit to merge
// edit to merge 2

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/token', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('cards', CardController::class)->middleware('auth:sanctum');
Route::apiResource('links', LinkController::class)->middleware('auth:sanctum');

Route::get('/cards-number', function(Request $request){
    $user = $request->user();
    $cards = Card::where('user_id', $user->id)->get();
    return['you have '.count($cards).' cards'];
})->middleware('auth:sanctum');