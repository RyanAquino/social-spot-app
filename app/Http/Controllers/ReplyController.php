<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Comment;
use App\User;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct() {
    //     $this->middleware(['auth:api']);
    // }

    public function store(Request $request)
    {
        // Reply
        $userId = auth()->user()->id;
        $reply = new Reply;
        $reply->comment_id = $request->route('id');
        $reply->reply = $request->reply;
        $reply->user_id = $userId;
        
        if($reply->save()){
            return $reply;
        }
    }

    public function show($id)
    {
        $reply = Comment::find($id);
        if(!$reply){
            return response()->json([
                'Error' => 'invalid comment id or no reply'
            ]);
        }
        $reply = $reply->reply;
        if(!$reply){
            return response()->json([
                'Error' => 'invalid comment id or no reply'
            ]);
        }
        $user = User::find($reply->user_id);
        $reply->user = $user->email;

        return $reply;
    }

}
