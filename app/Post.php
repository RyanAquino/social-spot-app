<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements JWTSubject
{
    public function user(){
        return $this->belongsTo("App\User");
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

}
