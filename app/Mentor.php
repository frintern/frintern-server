<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mentor extends Model
{
    //

    use SoftDeletes;

    public function expertiseAreas()
    {
        return $this->hasMany('App\UserExpertise');
    }

    public function scopeRecommended($query, $userInterests)
    {


    }

    public function user()
    {
        $this->belongsTo('App\User');
    }
}
