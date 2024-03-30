<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LinkController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sanctum/token', [AuthController::class, 'login']);
Route::post('/sanctum/signup', [AuthController::class, 'signup']);

Route::apiResource('cards', CardController::class)->middleware('auth:sanctum');
Route::apiResource('links', LinkController::class)->middleware('auth:sanctum');
// Route::apiResource('links', LinkController::class)->middleware('auth:sanctum');