<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendsController extends Controller
{
    public function attend(Request $req) {
        $date = date("Y-m-d H:i:s");
        $time = date("H:i:s");
        $point = strtotime('09:00:00');
        $timestamp = strtotime($time);
        $result = $timestamp - $point;

        $attend = new Attend();
        $userId = Auth::user()->id;
        // $userId = 1;
        if ($result > 0) {
            $cul = number_format($result/60/5); // 바퀴 수
            if ($cul == 0) $cul = 1;
            $attend->run = $cul;
        }

        $attend->user_id = $userId;
        $attend->attend = $date;
        // $attend->save();

        $res = response()->json([
            'status' => 'success',
            'data' => $attend
        ], 200);

        return $res;
    }
}
