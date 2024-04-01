<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LinkController;
use App\Models\Card;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sanctum/token', [AuthController::class, 'login']);
Route::post('/sanctum/signup', [AuthController::class, 'signup']);

Route::apiResource('cards', CardController::class)->middleware('auth:sanctum');
Route::apiResource('links', LinkController::class)->middleware('auth:sanctum');
// Route::apiResource('links', LinkController::class)->middleware('auth:sanctum');
Route::get('/cards-number', function(Request $request){
    $user = $request->user();
    $cards = Card::where('user_id', $user->id)->get();
    return['you have '.count($cards).' cards'];
})->middleware('auth:sanctum');