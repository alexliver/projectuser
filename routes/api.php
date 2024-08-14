<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;

Route::apiResource('users', UserController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('timesheets', TimesheetController::class);
