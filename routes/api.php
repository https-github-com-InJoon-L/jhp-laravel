<?php

use App\Http\Controllers\Attend_commentsController;
use App\Http\Controllers\Attend_postsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RunsController;
use App\Http\Controllers\TimetablesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentsController;

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






// 관리자 페이지, 유저 수정 관련
Route::get('/users', [UsersController::class, 'read']);
Route::patch('/user/{selected_user_id}', [UsersController::class, 'update']);

// 랭크 관련 (나중에 해당년도 별로 뽑아오기로 수정??)
Route::get('/users/runners', [UsersController::class, 'theMostestRunner']);
Route::get('/users/absentees', [UsersController::class, 'theMostestAbsentee']);
Route::get('/users/latecomers', [UsersController::class, 'theMostestLatecomer']);
Route::get('/users/rank', [UsersController::class, 'getUsersAttendsByDate']);

// 출결 현황
Route::get('/class/{team_id}', [UsersController::class, 'attendStatusByDate']); // GET /api/class/2?date=2021-08-26
Route::get('/class/{team_id}/attend', [UsersController::class, 'classAttendStatus']);
Route::get('/user/{user_id}/attend/month', [UsersController::class, 'userAttendStatusByMonth']);
Route::get('/user/{user_id}/attend/week', [UsersController::class, 'userAttendStatusByWeek']);
Route::get('/user/attendance/{user_id}', [UsersController::class, 'getAttendanceStatus']);
Route::get('/user/attendStatus/{user_id}', [UsersController::class, 'getUserStatus']);

// run 달리면
Route::patch('/run/{selected_post_id}', [RunsController::class, 'minusRun']);

//Attend_posts 달리기 인증 게시판
Route::post('/attend_posts/create', [Attend_postsController::class, 'create']);
Route::get('/attend_posts/index', [Attend_postsController::class, 'index']);
Route::get('/attend_posts/{selected_post_id}', [Attend_postsController::class, 'show']);
Route::put('/attend_posts/{selected_post_id}', [Attend_postsController::class, 'update']);
Route::delete('/attend_posts/{selected_post_id}', [Attend_postsController::class, 'destroy']);
Route::get('/attend_posts/search/{searched_user_name}', [Attend_postsController::class, 'search']);

// Post 자유 게시판
Route::post('/posts/create', [PostsController::class, 'create']);
Route::get('/posts/index', [PostsController::class, 'index']);
Route::get('/posts/{selected_post_id}', [PostsController::class, 'show']);
Route::put('/posts/{selected_post_id}', [PostsController::class, 'update']);
Route::delete('/posts/{selected_post_id}', [PostsController::class, 'destroy']);
Route::get('/posts/search/{searched_title}', [PostsController::class, 'search']);

// Attend_comments 달리기 인증 게시판 댓글
Route::post('/post/{postId}/comment', [Attend_commentsController::class, 'create']);
Route::delete('/comment/{comment}', [Attend_commentsController::class, 'destroy']);
Route::patch('/comment/{comment}', [Attend_commentsController::class, 'update']);

// Comment 자유 게시판 댓글
Route::post('/post_free/{postId}/comment', [CommentsController::class, 'create']);
Route::delete('/comment_free/{comment}', [CommentsController::class, 'destroy']);
Route::patch('/comment_free/{comment}', [CommentsController::class, 'update']);
