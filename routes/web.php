<?php

use App\Http\Controllers\SocialController;
use App\Http\Controllers\ProfessorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return Inertia::render('Dashboard');
})->name('main');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => ['web']], function () {
    Route::middleware(['cors'])->group(function () {
        Route::get('/csrf_token', function(){
            return csrf_token()+1;
        });
        Route::get('/login/kakao',[SocialController::class,'redirect'])->name('kakao.login');
    });
});

Route::get('/login/kakao/callback',[SocialController::class,'callback'])->name('kakaocall');
Route::middleware(['auth:sanctum', 'verified'])->get('/setInfo', function () {
    return Inertia::render('Auth/AddInfo');
})->name('setInfo');


Route::middleware(['auth:sanctum', 'verified','auth'])->get('/attend', function () {
    return Inertia::render('Menu/Attend');
})->name('attend');

Route::post('setInfo/save', [SocialController::class, 'inputData'])->name('input');

Route::middleware(['cors'])->group(function () {
    Route::get('/csrf_token', function(){
        return csrf_token();
    });
    Route::get('/notice',function() {
        return Inertia::render('Board/Notice');
    })->name('notice');
});

Route::get('/timetable',function() {
    return Inertia::render('TimeTable/TimeTable');
})->name('timetable');

Route::middleware(['auth:sanctum', 'verified'])
            ->get('/dashboard/professor',[ProfessorController::class,'index'])
            ->name('dashboard.professor');
