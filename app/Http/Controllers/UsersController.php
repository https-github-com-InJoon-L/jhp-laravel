<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    // 랜더링시 팀별로 배열 보내기
    // name email phone_number class sid postion current_team_id
    // user의 id가 요청으로 옴

    public function read() {
        // 읽기 권한 검사
        // if(Auth::user()->current_team_id != 4) {
        //     abort(403);
        // }
        $user = [
            'user_team_1' => User::all()->where('current_team_id', 1),
            'user_team_2' => User::all()->where('current_team_id', 2),
            'user_team_3' => User::all()->where('current_team_id', 3),
            'user_team_4' => User::all()->where('current_team_id', 4)
        ];

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    // 권한설정 (팀아이디 수정)
    public function update(Request $request) {
        // 수정 권한 검사
        // if(Auth::user()->current_team_id != 4) {
        //     abort(403);
        // }

        $user = User::find($request->selected_user_id);
        $user->current_team_id = $request->team_id;

        $user->save();

        return response()->json([
            'status' => 'success',
        ], 200);
    }
}
