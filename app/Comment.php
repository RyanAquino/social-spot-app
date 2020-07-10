<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function toPost(){
        return $this->belongsTo("App\Post");
    }
}
