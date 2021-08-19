<?php

use App\Http\Controllers\Attend_postsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RunsController;
use App\Http\Controllers\TimetablesController;
use App\Models\Attend_posts;

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
Route::patch('/attends/{selected_user_id}', [AttendsController::class, 'update']);
// test용
Route::post('/token', [AuthController::class, 'createApiToken']);
// 회원탈퇴시 할 것
Route::delete('/token/delete', [AuthController::class, 'deleteApiToken']);

Route::get('/timetables', [TimetablesController::class, 'getTimetables']);

// run 달리면
Route::patch('/run/{selected_post_id}', [RunsController::class, 'minusRun']);

//Attend_posts 달리기 인증 게시판
Route::post('/attend_posts/create', [Attend_postsController::class, 'create']);
Route::get('/attend_posts/index', [Attend_postsController::class, 'index']);
Route::get('/attend_posts/{selected_post_id}', [Attend_postsController::class, 'show']);
Route::put('/attend_posts/{selected_post_id}', [Attend_postsController::class, 'update']);
Route::delete('/attend_posts/{selected_post_id}', [Attend_postsController::class, 'destroy']);

