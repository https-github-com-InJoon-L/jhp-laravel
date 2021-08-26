<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostsController extends Controller
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


    // 자유 게시판 생성
    public function create(Request $req) {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer',
            'title' => 'required|string',
            'content' => 'required|string',
            'imageFile' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $post = new Post();
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

    // 자유 게시판 전체 보여주기
    public function index() {
        $posts = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->select(
            DB::raw("DATE_FORMAT(posts.created_at, '%Y-%m-%d') as date"),
            DB::raw("DATE_FORMAT(posts.updated_at, '%Y-%m-%d') as updated_date"),
            DB::raw('posts.id, posts.title,
            posts.content, posts.user_id, posts.image,
            posts.updated_at, users.name'),
        )->orderBy('date', 'desc')->paginate(10);

        // 댓글은 따로 또 만들어야 함
        // $commentsCount = DB::table('attend_comments')
        // ->join('attend_posts', 'attend_posts.id', '=', 'attend_comments.attend_post_id')
        // ->select(
        //     DB::raw('attend_posts.id, COUNT(attend_comments.id) as count')
        // )->groupBy('attend_posts.id')->orderBy('attend_posts.created_at', 'desc')
        // ->get();

        // $i = 0;
        // $flag = true;

        // foreach($posts as $row) {
        //     if ($flag && $row->id == $commentsCount[$i]->id) {
        //         $row->comments_count = $commentsCount[$i]->count;
        //         $i++;

        //         if ($commentsCount->count() <= $i) {
        //             $flag = false;
        //         }
        //     } else {
        //         $row->comments_count = null;
        //     }
        // }

        $res = response()->json([
            'status' => 'success',
            'posts' => $posts
        ], 200);

        return $res;
    }

    // 자유게시판 상세보기
    public function show($selected_post_id) {
        $post = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->where('posts.id', '=', $selected_post_id)
        ->select(
            DB::raw("DATE_FORMAT(posts.created_at, '%Y-%m-%d %T') as date"),
            DB::raw('posts.id, posts.title, posts.content,
            posts.user_id, posts.image,
            posts.updated_at, users.name, users.profile_photo_path'),
        )
        ->get();

        // 댓글 따로 만들어야함
        // $comment = DB::table('attend_comments')
        // ->join('users', 'users.id', '=', 'attend_comments.user_id')
        // ->where('attend_post_id', '=', $selected_post_id)
        // ->select(
        //     DB::raw('attend_comments.id, attend_comments.content, users.name, attend_comments.attend_post_id,
        //     attend_comments.created_at, attend_comments.updated_at')
        // )
        // ->get();

        // for ($i = 0; $i < $comment->count(); $i++) {
        //     $comment[$i]->updated_at = Carbon::parse($comment[$i]->updated_at);
        //     $comment[$i]->updated_at = $comment[$i]->updated_at->diffForHumans(Carbon::now());
        // }

        $res = response()->json([
            'status' => 'success',
            'post' => $post,
            // 'comment' => $comment,
        ]);

        return $res;
    }

    // 자유 게시판 수정
    public function update(Request $req, $selected_post_id) {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer',
            'title' => 'required|string',
            'content' => 'required|string',
            'imageFile' => 'image|Max:2000',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $post = Post::find($selected_post_id);

        if ($req->user_id != $post->user_id) {
            $res = response()->json([
                'status' => 'false',
                'message' => '작성자가 아닙니다.',
            ], 200, [], JSON_UNESCAPED_UNICODE);

            return $res;
        }

        if ($req->file('imageFile')) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
            $post->image = $this->uploadPostImage($req);
        } else {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
            $post->image = '';
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

    // 자유 게시판 삭제
    public function destroy(Request $req, $selected_post_id) {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $post = Post::find($selected_post_id);

        if ($req->user_id != $post->user_id) {
            $res = response()->json([
                'status' => 'false',
                'message' => '작성자가 아닙니다.',
            ], 200, [], JSON_UNESCAPED_UNICODE);

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
        ], 200, [], JSON_UNESCAPED_UNICODE);

        return $res;
    }

    // 자유 게시판 검색하기
    public function search($searched_title) {
        $posts = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->where('posts.title', 'like', '%'.$searched_title.'%')
        ->select(
            DB::raw("DATE_FORMAT(posts.created_at, '%Y-%m-%d') as date"),
            DB::raw("DATE_FORMAT(posts.updated_at, '%Y-%m-%d') as updated_date"),
            DB::raw('posts.id, posts.title, posts.content,
            posts.user_id, posts.image,
            posts.updated_at, users.name'),
        )->orderBy('date', 'desc')->paginate(10);


        // 댓글은 다시
        // $commentsCount = DB::table('attend_comments')
        // ->join('attend_posts', 'attend_posts.id', '=', 'attend_comments.attend_post_id')
        // ->select(
        //     DB::raw('attend_posts.id, COUNT(attend_comments.id) as count')
        // )->groupBy('attend_posts.id')->orderBy('attend_posts.created_at', 'desc')
        // ->get();

        // foreach($posts as $row) {
        //     $flag = true;
        //     for ($j = 0; $j < $commentsCount->count(); $j++) {
        //         if ($row->id == $commentsCount[$j]->id) {
        //             $row->comments_count = $commentsCount[$j]->count;
        //             $flag = false;
        //             break;
        //         }
        //     }

        //     if ($flag) {
        //         $row->comments_count = null;
        //     }
        // }

        $res = response()->json([
            'status' => 'success',
            'posts' => $posts
        ], 200);

        return $res;
    }
}
