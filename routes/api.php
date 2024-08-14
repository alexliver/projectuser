<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;

Route::apiResource('users', UserController::class);
Route::apiResource('projects', ProjectController::class);
