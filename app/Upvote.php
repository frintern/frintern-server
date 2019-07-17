<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upvote extends Model
{
    //


    public function upvotable()
    {
        return $this->morphTo();
    }
}
