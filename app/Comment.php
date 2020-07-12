<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function reply(){
        return $this->hasOne('App\Reply');
    }

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function toPost(){
        return $this->belongsTo("App\Post");
    }
}
