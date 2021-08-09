<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendsController extends Controller
{
    public function attend(Request $req) {
        $validator = Validator::make($req->all(), [
            'user_sid' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $date = date("Y-m-d");
        $time = date("H:i:s");
        $point = strtotime('09:00:00');
        $timestamp = strtotime($time);
        $result = $timestamp - $point;

        $attend = new Attend();
        // $userId = Auth::user()->id; // api.php는 비저장 상태라 토큰을 받아오지 않는 한 인증이 불가
        $userId = User::where('sid', $req->user_sid)->first()->id;

        // 오늘 출석 했는지 판단 후 했다면 디비에 넣지 않고 return false
        if (Attend::where('attend', $date)->where('user_id', $userId)->get()->count() != 0) {
            return $res = response()->json([
                'status' => 'false',
                'message' => '오늘은 이미 출석 했습니다.',
            ]);
        }

        if ($result > 0) {
            $cul = number_format($result/60/5); // 바퀴 수
            $cul++;
            $attend->run = $cul;
            $attend->desc_value = '지각';

            $this->insertRun($userId);
        }

        $attend->user_id = $userId;
        $attend->attend = $date;
        $attend->save();


        $res = response()->json([
            'status' => 'success',
            'data' => $attend
        ], 200);

        return $res;
    }

    public function insertRun($userId) {

    }
}
