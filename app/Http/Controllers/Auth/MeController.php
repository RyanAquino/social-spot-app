<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\User;
use Illuminate\Support\Facades\DB;

class MeController extends Controller
{
    //
    // public function __construct() {
    //     $this->middleware(['auth:api']);
    // }
    
    public function index(Request $request){
        $user = auth()->userOrFail();

        return response()->json([
            'email' => $user->email,
            'name' => $user->name
        ]);
    }

    public function user(Request $request){
        $user = auth()->user();

        return response()->json([
            'user' => $user
        ]);
    }

    public function get_posts(Request $request){
        $user = auth()->user();
        if(!$user){
            return response()->json([
                'Error' => 'user id not found'
            ],404);
        }

        $posts = $user->posts()->get();
        return $posts;
    }

    public function myFriends(){
        $user = auth()->user();
        if(!$user){
            return response()->json([
                'Error' => 'something went wrong'
            ],404);
        }

        $user_id = $user->id;
        $friends = DB::table('users')->where('id', '>', $user_id)->get();

        return $friends;

    }

    public function update(Request $request){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        if(!$user){
            return response()->json([
                'Error' => 'user not founed'
            ]);
        }
        
        $name = $request->name;
        $email = $request->email;
        $password= $request->password;

        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);

        if($user->save()){
            return $user;
        }
    }
}
