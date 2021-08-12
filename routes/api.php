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

Route::post('/absence', [AttendsController::class, 'absent']);

Route::get('/timetables', [TimetablesController::class, 'getTimetables']);



// 관리자 페이지, 유저 수정 관련
Route::get('/users', [UsersController::class, 'read']);
Route::patch('/user/{selected_user_id}', [UsersController::class, 'update']);

// 랭크 관련 (나중에 해당년도 별로 뽑아오기로 수정??)
Route::get('/users/runners', [UsersController::class, 'theMostestRunner']);
Route::get('/users/absentees', [UsersController::class, 'theMostestAbsentee']);
Route::get('/users/latecomers', [UsersController::class, 'theMostestLatecomer']);

// 출결 현황
Route::get('/user/attendance/{selected_user_id}', [UsersController::class, 'getAttendanceStatus']);


