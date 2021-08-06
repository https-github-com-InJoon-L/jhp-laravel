<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function read() {
        // 읽기 권한 검사
        // if(Auth::user()->current_team_id != 4) {
        //     abort(403);
        // }
        $users = [
            'none' => User::all()->where('current_team_id', 1),
            'wdj' => User::all()->where('current_team_id', 2),
            'cpj' => User::all()->where('current_team_id', 3),
            'professor' => User::all()->where('current_team_id', 4)
        ];

        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    // 권한설정 (팀아이디 수정)
    public function update(Request $request, $selected_user_id) {
        // 수정 권한 검사
        // if(Auth::user()->current_team_id != 4) {
        //     abort(403);
        // }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'sid' => 'required|integer|unique:users',
            'current_team_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::find($selected_user_id);
        $user->fill($request->all());

        $user->save();

        return response()->json([
            'status' => 'success',
        ], 200);
    }
}
