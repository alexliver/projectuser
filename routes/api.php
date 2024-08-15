<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserProjectManagementController;

Route::apiResource('users', UserController::class)->middleware('auth:api');
Route::apiResource('projects', ProjectController::class)->middleware('auth:api');
Route::apiResource('timesheets', TimesheetController::class)->middleware('auth:api');
Route::post('/users/register/', [UserController::class, 'register']);
Route::get('/user-project-management/join-project/{id}', 
    [UserProjectManagementController::class, 'joinProject'])->middleware('auth:api');
Route::get('/user-project-management/my-projects/', 
    [UserProjectManagementController::class, 'myProjects'])->middleware('auth:api');
