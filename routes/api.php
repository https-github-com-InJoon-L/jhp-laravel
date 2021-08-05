<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendsController;
use App\Http\Controllers\UsersController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/attends', [AttendsController::class,'attend']);



// Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/users', [UsersController::class, 'read']);
    Route::patch('/user/{selected_user_id}', [UsersController::class, 'update']);
// });