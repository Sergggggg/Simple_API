<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


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

Route::get('/token', [AuthController::class, 'getToken']);

Route::get('/users/{id}', [AuthController::class, 'user']);


Route::get('/users/{page?}/{count?}', [AuthController::class, 'users']);


Route::get('/positions', [AuthController::class, 'positions']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
