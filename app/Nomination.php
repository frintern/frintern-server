<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomination extends Model
{
    //
    public function nominator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
