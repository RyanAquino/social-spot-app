<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:api']);
    }

    public function getPostComments(Request $request){
        $post_id = $request->route('id');

        $comments = DB::table('users')
        ->join('comments','comments.user_id','=','users.id')
        ->where('comments.post_id','=',$post_id)->orderBy('comments.created_at','desc')->get();

        return $comments;

    }

    public function replyToComment(Request $request){
      
    }

    public function getReplyComment(Request $request){
        
    }
}
