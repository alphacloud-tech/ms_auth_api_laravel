<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
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

// public route 
Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);
Route::get('/v1/user', [AuthController::class, 'userList']);
Route::get('/v1/user/{id}', [AuthController::class, 'showUser']);
Route::get('/v1/logout', [AuthController::class, 'logout']);

// Route::group(['middleware' => ['auth:sanctum']], function () { 
//     // Route::get('/v1/user', [AuthController::class, 'userList']);
//     // Route::get('/v1/user/{id}', [AuthController::class, 'showUser']);
//     Route::get('/v1/logout', [AuthController::class, 'logout']);
// });











Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


