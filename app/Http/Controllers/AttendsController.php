<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendsController extends Controller
{
    public function attend(Request $req) {
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $point = strtotime('09:00:00');
        $timestamp = strtotime($time);
        $result = $timestamp - $point;

        $cul = $result/60; // 차이
        return $cul;
    }
}
