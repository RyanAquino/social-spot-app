<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\User;
// use Illuminate\Support\Facades\DB;

class MeController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:api']);
    }

    public function me(Request $request){
        $user = auth()->user();

        return response()->json([
            'user' => $user
        ]);
    }

    public function getUser(Request $request){
        $user = User::find($request->route('id'));

        return $user;
    }

    public function update(Request $request){
        $user = auth()->user();

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

    // Get recent 8 posts of a user
    public function getUserPosts(Request $request){
        $user = auth()->user();
        $posts = $user->posts()->take(8)->get();

        return $posts;
    }

    public function userFriends(){
        $user = auth()->user();
        $user_id = $user->id;
        $friends = User::where('id', '>', $user_id)->get();

        return $friends;
    }
    
}
