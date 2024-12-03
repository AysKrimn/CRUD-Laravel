<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::apiResource('api/users', UserController::class);

