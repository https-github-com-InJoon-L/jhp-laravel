<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\Run;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttendsController extends Controller
{
    public function attend(Request $req) {
        $validator = Validator::make($req->all(), [
            'user_sid' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'false',
                'data' => $validator->errors()
            ], 200);
        }

        $date = date("Y-m-d");
        $time = date("H:i:s");
        $attend_start = strtotime('18:45:00');
        $attend_end = strtotime('21:00:00');
        $point = strtotime('19:01:00');

        $timestamp = strtotime($time);
        $result = $timestamp - $point;

        $attend = new Attend();
        // $userId = Auth::user()->id; // api.php는 비저장 상태라 토큰을 받아오지 않는 한 인증이 불가
        $userId = User::where('sid', $req->user_sid)->first()->id;

        // 오늘 출결 했는지 판단 후 했다면 디비에 넣지 않고 return false
        if (Attend::where('attend', $date)->where('user_id', $userId)->get()->count() != 0) {
            return $res = response()->json([
                'status' => 'false',
                'message' => '오늘은 이미 출결 했습니다.',
            ]);
        }

        // 18:45 ~ 21:00에만 출석이 가능
        if ($timestamp < $attend_start || $timestamp > $attend_end) {
            return $res = response()->json([
                'status' => 'false',
                'message' => '지금은 출석 할 수 없는 시간입니다.',
            ]);
        }

        if ($result > 0) {
            $cul = number_format($result/60/5); // 바퀴 수
            $cul++;
            if ($cul > 12) $cul = 12;

            $attend->run = $cul;
            $attend->desc_value = '지각';

            // 첫 번째 인자 학번, 두 번째 인자 오늘 run 수 세 번째 인자 user_id
            $this->insertRun($attend->run, $userId);
        } else {
            $attend->desc_value = '출석';
        }

        $attend->user_id = $userId;
        $attend->attend = $date;
        $attend->save();

        $res = response()->json([
            'status' => 'success',
            'data' => $attend,
            'message' => $date.' 출석했습니다.',
        ], 200);

        return $res;
    }

    // 첫 번째 인자 오늘 run 두 세 번째 인자 user_id
    public function insertRun($todayRun, $userId) {
        $run = null;
        $countRun = $todayRun;
        $totalRun = User::find($userId)->attends()->sum('run');

        if (Run::where('user_id', $userId)->get()->count() == 0) {
            $run = new Run();
            $run->user_id = $userId;
        } else {
            $run = Run::where('user_id', $userId)->first();
        }

        $run->countRun = $run->countRun + $countRun;
        // 오늘 출석 데이터가 디비에 들어가기 전에 실행 되기 때문에 전날까지만 가져오므로 오늘꺼 더해준다.
        $run->totalRun = $totalRun + $countRun;

        $run->save();
    }

    // 출석하지 않은 유저들 반별로
    public function notAttendUsers($date) {
        // $date = date("Y-m-d");
        $users = User::where('class', 'wdj')->get();
        $attend_users = Attend::where('attend', $date)->get();
        $users_array = $users->toArray();

        // 하루에 한명도 출석 안할 시
        if ($attend_users->count() == 0) {
            $res = response()-> json([
                'status' => 'success',
                'not_users' => $users_array,
                'absent' => null,
                'tardy' => null
            ]);

            return $res;
        }

        $count = 0;

        // 한명이라도 출석 했다면
        for ($i = 0; $i < $users->count(); $i++) {
            for ($j = 0; $j < $attend_users->count(); $j++) {
                if($users[$i]->id == $attend_users[$j]->user_id) {
                    array_splice($users_array, $i - $count, 1);
                    $count++;
                    break;
                }
            }
        }

        // 지각한 사람
        $tardy = DB::table('attends')
        ->join('users', 'users.id', '=', 'attends.user_id')
        ->where('attends.attend', '=', $date)
        ->where('attends.desc_value', 'like', '%지각%')
        ->where('users.class', '=', 'wdj')
        ->select(
            DB::raw("users.id, users.name, users.email, users.class,
            users.sid, users.profile_photo_path, attends.id, attends.run,
            attends.desc_value"),
            DB::raw("DATE_FORMAT(attends.updated_at, '%Y-%m-%d %T') as updated_date")
        )->get();

        $absent = DB::table('attends')
        ->join('users', 'users.id', '=', 'attends.user_id')
        ->where('attends.attend', '=', $date)
        ->where('attends.desc_value', 'like', '%결석%')
        ->where('users.class', '=', 'wdj')
        ->select(
            DB::raw("users.id, users.name, users.email, users.class,
            users.sid, users.profile_photo_path, attends.id, attends.run,
            attends.desc_value"),
            DB::raw("DATE_FORMAT(attends.updated_at, '%Y-%m-%d %T') as updated_date")
        )->get();


        $res = response()-> json([
            'status' => 'success',
            'not_users' => $users_array,
            'absent' => $absent,
            'tardy' => $tardy
        ]);

        return $res;
    }

    // 결석 처리
    public function absent(Request $req) {
        $validator = Validator::make($req->all(), [
            'user_sid' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'false',
                'data' => $validator->errors()
            ], 200);
        }

        $date = date("Y-m-d");
        $userId = User::where('sid', $req->user_sid)->first()->id;

        // 오늘 출결 했는지 판단 후 했다면 디비에 넣지 않고 return false
        if (Attend::where('attend', $date)->where('user_id', $userId)->get()->count() != 0) {
            return response()->json([
                'status' => 'false',
                'message' => '오늘은 이미 출결 했습니다.',
            ]);
        }

        $absent_user = new Attend();
        $absent_user->user_id = $userId;
        $absent_user->desc_value = '결석';
        $absent_user->attend = $date;
        $absent_user->run = 12;

        $absent_user->save();

        $res = response()-> json([
            'status' => 'success',
            'data' => $absent_user,
            'message' => $date.' 결석했습니다.',
        ]);

        return $res;
    }

    // 출석정보 수정
    public function update(Request $req, $selected_user_id) {
        $validator = Validator::make($req->all(), [
            'run' => 'required|integer',
            'desc_value' => 'required|string',
            'attend' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'false',
                'data' => $validator->errors()
            ], 200);
        }

        $updateAttend = User::find($selected_user_id)->attends()->where('attend', $req->attend)->first();
        $updateAttend->desc_value = $req->desc_value;

        if ($updateAttend->run != $req->run) {
            $this->updateRun($selected_user_id, $updateAttend->run);
            $updateAttend->run = $req->run;
        }

        $updateAttend->save();

        $res = response()-> json([
            'status' => 'success',
            'data' => $updateAttend,
            'message' => '출석정보가 변경되었습니다.',
        ]);

        return $res;
    }

    public function updateRun($user_id, $run) {
        $runDate = Run::where('user_id', $user_id)->first();
        $runDate->countRun = $runDate->countRun - $run;
        $runDate->totalRun = $runDate->totalRun - $run;

        $runDate->save();
    }
}
