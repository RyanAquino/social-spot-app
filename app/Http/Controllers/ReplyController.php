<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Comment;
use App\User;

class ReplyController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:api']);
    }

    public function store(Request $request)
    {
        if(!$request->reply){
            return response()->json([
                'Error' => 'body required'
            ],400);
        }

        $comment = Comment::find($request->route('id'));

        if(!$comment){
            return response()->json([
                'Error'=>'comment not found'
            ],404);
        }

        $userId = auth()->user()->id;
        $reply = new Reply;
        $reply->comment_id = $request->route('id');
        $reply->reply = $request->reply;
        $reply->user_id = $userId;
        
        if($reply->save()){
            return $reply;
        }
    }

    public function show(Request $request)
    {
        $comment = Comment::find($request->route('id'));
        if(!$comment){
            return response()->json([
                'Error' => 'invalid comment id | no reply'
            ]);
        }
        
        $reply = $comment->reply;
        
        if(!$reply){
            return response()->json([
                'Error' => 'reply not found'
            ]);
        }

        $user = User::find($reply->user_id);
        $reply->user = $user->email;

        return $reply;
    }
}
