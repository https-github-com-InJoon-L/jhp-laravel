<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimetablesController;
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

// api_token header에 넣어서 보내주기
// axios.defaults.headers.common["Authorization"] = `Bearer ${발급받은 token}`;
Route::middleware(['auth:sanctum'])->group(function () {
    // api token으로 인증을 받아야 하는 api 넣기

});

// axios.Post('/api/attends') <- 요청 방법
Route::post('/attends', [AttendsController::class, 'attend']);
Route::post('/attends/absent', [AttendsController::class, 'absent']);
Route::get('/attends/not_users', [AttendsController::class, 'notAttendUsers']);

// test용
Route::post('/token', [AuthController::class, 'createApiToken']);
// logout이 어디서 작동하는 지 몰라서 못 넣음 로그아웃 button 클릭 시 이 api에 요청 보내주세욤ㅎㅎ
Route::delete('/token/delete', [AuthController::class, 'deleteApiToken']);

Route::get('/timetables', [TimetablesController::class, 'getTimetables']);






// 관리자 페이지, 유저 수정 관련
Route::get('/users', [UsersController::class, 'read']);
Route::patch('/user/{selected_user_id}', [UsersController::class, 'update']);

// 랭크 관련 (나중에 해당년도 별로 뽑아오기로 수정??)
Route::get('/users/runners', [UsersController::class, 'theMostestRunner']);
Route::get('/users/absentees', [UsersController::class, 'theMostestAbsentee']);
Route::get('/users/latecomers', [UsersController::class, 'theMostestLatecomer']);

// 출결 현황
Route::get('/user/attendance/{user_id}', [UsersController::class, 'getAttendanceStatus']);
Route::get('/user/attendStatus/{user_id}', [UsersController::class, 'getUserStatus']);