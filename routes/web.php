<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('assignRoles', [UserController::class, 'assignRoles']);

Route::middleware('check.retailer')->group(function () {
    Route::get('/spin-wheel', [SpinWheelController::class, 'index']);
});
