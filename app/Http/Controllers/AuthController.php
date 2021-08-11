<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // token 발급
    public function createApiToken(Request $req) {
        $user = User::where('id', $req->id)->first();

        $token = $user->createToken($req->name);

        return $token->plainTextToken;
    }

    // token 제거
    public function deleteApiToken(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::find($req->id);
        // $token = $user->tokens()->get();
        $user->tokens()->delete();
        // $deletedToken = $user->tokens()->get();

        $res = response()->json([
            'status' => 'success'
        ], 200);

        return $res;
    }
}
