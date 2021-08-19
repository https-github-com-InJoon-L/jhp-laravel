<?php

namespace App\Http\Controllers;

use App\Models\Run;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RunsController extends Controller
{
    // user_id랑 달린 수(run)
    public function minusRun(Request $req) {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer',
            'run' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $run = Run::where('user_id', $req->user_id)->first();

        $run->countRun = $run->countRun - $req->run;
        $run->minusRun = $run->minusRun + $req->run;

        $run->save();

        $res = response()->json([
            'status' => 'success',
            'run' => $run,
        ]);

        return $res;
    }
}
