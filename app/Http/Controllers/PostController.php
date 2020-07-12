<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Comment;
use App\User;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{

    public function __construct() {
        $this->middleware(['auth:api']);
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);

        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        if(!$request->body){
            return response()->json([
                'Error' => 'body field is required'
            ]);
        }

        $userId = auth()->user()->id;
        
        $post = new Post;
        $post->user_id = $userId;
        $post->body = $request->body;
        
        if($post->save()){
            return $post;
        }
    }

    public function like(Request $request)
    {
        $post = Post::find($request->route('id'));

        if(!$post){
            return response()->json([
                'Error' => 'post not found'
            ], 404);
        }

        $post->likes++;

        if($post->save()){
            return $post;
        }
    }

    public function comment(Request $request)
    {
        $userId = auth()->user()->id;
        $post = Post::find($request->route('id'));

        if(!$post){
            return response()->json([
                'Error' => 'post not found'
            ], 404);
        }

        if(!$request->comment){
            return response()->json([
                'Error' => 'comment required'
            ]);
        }

        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->user_id = $userId;
        $comment->post_id = $request->route('id');

        if($comment->save()){
            return $comment;
        }
    }
}
