<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SpinController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [RegisterController::class, 'register']);

// Login route
Route::post('login', [LoginController::class, 'login']);

// Logout route (requires authentication)
Route::middleware('auth:sanctum')->post('logout', [LogoutController::class, 'logout']);

// Example of a secured route
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/spin/use', [SpinController::class, 'useSpin']);
    Route::post('/spin/buy', [SpinController::class, 'buySpin']);
    Route::get('/spin/history', [SpinController::class, 'getUserSpinHistory']);
    Route::get('/admin/spin/history', [SpinController::class, 'getAdminSpinHistory'])->middleware('can:admin');
});
