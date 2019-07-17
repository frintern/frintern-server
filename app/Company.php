<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    public function interests()
    {
        return $this->belongsToMany('App\Interest');
    }
}
