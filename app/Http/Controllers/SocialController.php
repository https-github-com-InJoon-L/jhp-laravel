<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
class SocialController extends Controller
{
    //

    public function redirect() {
        return Socialite::driver('kakao')->stateless()->redirect();
    }

    public function callback() {
        $userSocial = Socialite::driver('kakao')->stateless()->user();
        $userProfile = $userSocial->user['kakao_account']['profile']['profile_image_url'];
        $users = User::where(['email'=>$userSocial->getEmail(),'provider'=>'kakao'])->first();

        if($users)
        {
            $users->profile_photo_path = $userProfile;
            $users->save();
            Auth::login($users);
            $token = $users->createToken($users->name)->plainTextToken;
            return redirect('/')->with('api_token', $token); // blade: {{ session()->get('api_token')}} php: session()->get('api_token')
        }
        else {


            $user = new User;
            $user->name = $userSocial->name;
            $user->password = Hash::make(Str::random(8));
            $user->email = $userSocial->getEmail();
            $user->provider = 'kakao';
            $user->current_team_id = '1';
            $user->profile_photo_path = $userProfile;
            $user->save();

            $users = User::where(['email'=>$userSocial->getEmail(),'provider'=>'kakao'])->first();

            Auth::login($users);
            $token = $users->createToken($users->name)->plainTextToken;
            return redirect('/setInfo')->with('api_token', $token);
        }
    }

        // 로그인 후 추가정보 입력
        public function inputData(Request $req) {
            $validator = Validator($req->all(), [
                'sid' => 'required|integer',
                'class' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 'false',
                    'data' => $validator->errors()
                ], 200);
            }

            $sid = User::where('sid', $req->sid)->first();

            if($sid) {
                return response()->json([
                    'status' => 'false',
                    'message' => '학번이 이미 존재합니다.'
                ], 200, [], JSON_UNESCAPED_UNICODE);
            }

            $res = null;


            $user = User::find(Auth::user()->id);
            $user->phone_number = $req->phone_number;
            if($req->class == 'WDJ') {
                $user->current_team_id = 2;
            } else if($req->class == 'CPJ'){
                $user->current_team_id = 3;
            }
            $user->class = $req->class;
            $user->sid = $req->sid;
            $user->position = $req->position;
            $user->name = $req->name;

            $user->save();

            $res = response()->json([
                'status' => 'success',
                'data' => $user
            ], 200);

            return redirect()->route('dashboard', ['res' => $res]);
        }


}
