<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;

Route::apiResource('users', UserController::class)->middleware('auth:api');
Route::apiResource('projects', ProjectController::class)->middleware('auth:api');
Route::apiResource('timesheets', TimesheetController::class)->middleware('auth:api');
