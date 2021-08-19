<?php

namespace App\Http\Controllers;

use App\Models\Attend_posts;
use Illuminate\Http\Request;
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
            'title' => 'required|string',
            'content' => 'required|string',
            'imageFile' => 'image|Max:2000'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $post = new Attend_posts();
        $post->user_id = $req->user_id;
        $post->title = $req->title;
        $post->content = $req->content;

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
        $posts = Attend_posts::latest()->get()->fresh('user');

        $res = response()->json([
            'status' => 'success',
            'posts' => $posts
        ], 200);

        return $res;
    }

    // post 상세보기
    public function show($selected_post_id) {
        $post = Attend_posts::find($selected_post_id)->fresh('user');

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
            'title' => 'required|string',
            'content' => 'required|string',
            'imageFile' => 'image|Max:2000'
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

        $post->title = $req->title;
        $post->content = $req->content;
        $post->save();

        $res = response()->json([
            'status' => 'success',
            'post' => $post,
        ], 200);

        return $res;
    }
}
