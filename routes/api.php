<?php

use App\Http\Controllers\AttendsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\TimetablesController;
use App\Http\Controllers\UsersController;
use Inertia\Inertia;

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

// axios.Post('/api/attends') <- 요청 방법
Route::post('/attends', [AttendsController::class, 'attend']);

Route::get('/timetables', [TimetablesController::class, 'getTimetables']);

Route::get('/test',[ApiController::class,'test'])->name('api.test');

// Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/users', [UsersController::class, 'read']);
    Route::patch('/user/{selected_user_id}', [UsersController::class, 'update']);
// });