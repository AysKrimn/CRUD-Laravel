<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;



Route::get('api/users', [UserController::class, "index"]);
Route::post('api/users', [UserController::class, "store"]);
Route::get('api/users/{id}', [UserController::class, "show"]);
Route::put('api/users/{id}', [UserController::class, 'update']);
Route::delete('api/users/{id}', [UserController::class, 'destroy']);