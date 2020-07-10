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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {
        $this->middleware(['auth:api']);
    }

    public function index()
    {
        // Get all posts
        // $posts = Post::paginate(15);
        $posts = Post::all();

        return PostResource::collection($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Add Post
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
        //
        $post = Post::find($request->route('id'));

        if(!$post){
            return response()->json([
                'Error' => 'not found'
            ], 404);
        }

        $post->likes++;

        if($post->save()){
            return $post;
        }
    }

    public function comment(Request $request)
    {
        //
        $userId = auth()->user()->id;
        $post = Post::find($request->route('id'));

        if(!$post){
            return response()->json([
                'Error' => 'post not found'
            ], 404);
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
