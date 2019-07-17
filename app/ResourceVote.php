<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceVote extends Model
{
    //

    public function resource()
    {
        $this->belongsTo('App\Resource');
    }
}
