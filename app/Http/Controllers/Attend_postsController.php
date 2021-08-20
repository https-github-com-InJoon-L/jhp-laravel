<?php

namespace App\Http\Controllers;

use App\Models\Attend_posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Attend_postsController extends Controller
{
    public function uploadPostImage($req) {
        // 이름에 시간 넣기
        $name = $req->file('imageFile')->getClientOriginalName();
        $extension = $req->file('imageFile')->extension();
        $nameWithoutExtension = Str::of($name)->basename('.' . $extension);
        $fileName = $nameWithoutExtension . '_' . time() . '.' . $extension;

        // 파일의 경로와 이름 지정
        $req->file('imageFile')->storeAs('public/images', $fileName);

        return $fileName;
    }

    // post 생성
    public function create(Request $req) {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer',
            'content' => 'required|string',
            'run' => 'required|integer',
            'imageFile' => 'image|Max:2000'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $post = new Attend_posts();
        $post->user_id = $req->user_id;
        $post->content = $req->content;
        $post->run = $req->run;

        if ($req->file('imageFile')) {
            $post->image = $this->uploadPostImage($req);
        }

        $post->save();

        $res = response()->json([
            'status' => 'success',
            'post' => $post,
        ], 200);

        return $res;
    }

    // post 전체 보여주기
    public function index() {
        $posts = DB::table('attend_posts')
        ->join('users', 'users.id', '=', 'attend_posts.user_id')
        ->select(
            DB::raw("DATE_FORMAT(attend_posts.created_at, '%Y-%m-%d %T') as date"),
            DB::raw('attend_posts.id, attend_posts.content,
            attend_posts.user_id, attend_posts.image, attend_posts.flag,
            attend_posts.updated_at, attend_posts.run, users.name'),
        )->orderBy('date', 'desc')->paginate(10);

        $res = response()->json([
            'status' => 'success',
            'posts' => $posts
        ], 200);

        return $res;
    }

    // post 상세보기
    public function show($selected_post_id) {
        $post = DB::table('attend_posts')
        ->join('users', 'users.id', '=', 'attend_posts.user_id')
        ->where('attend_posts.id', '=', $selected_post_id)
        ->select(
            DB::raw("DATE_FORMAT(attend_posts.created_at, '%Y-%m-%d %T') as date"),
            DB::raw('attend_posts.id, attend_posts.content,
            attend_posts.user_id, attend_posts.image, attend_posts.flag,
            attend_posts.updated_at, attend_posts.run, users.name, users.profile_photo_path'),
        )->get();

        $res = response()->json([
            'status' => 'success',
            'post' => $post,
        ]);

        return $res;
    }

    // post 수정
    public function update(Request $req, $selected_post_id) {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer',
            'content' => 'required|string',
            'imageFile' => 'image|Max:2000',
            'run' => 'integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $post = Attend_posts::find($selected_post_id);

        if ($req->user_id != $post->user_id) {
            $res = response()->json([
                'status' => 'false',
                'message' => '작성자가 아닙니다.',
            ], 403);

            return $res;
        }

        if ($req->file('imageFile')) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
            $post->image = $this->uploadPostImage($req);
        }

        $post->content = $req->content;
        if ($req->run != null) {
            $post->run = $req->run;
        }

        $post->save();

        $res = response()->json([
            'status' => 'success',
            'post' => $post,
        ], 200);

        return $res;
    }

    public function destroy(Request $req, $selected_post_id) {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $post = Attend_posts::find($selected_post_id);

        if ($req->user_id != $post->user_id) {
            $res = response()->json([
                'status' => 'false',
                'message' => '작성자가 아닙니다.',
            ], 403);

            return $res;
        }

        if ($post->image) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
        }

        $post->delete();

        $res = response()->json([
            'status' => 'ture',
            'message' => '삭제가 되었습니다.',
        ], 200);

        return $res;
    }
}
