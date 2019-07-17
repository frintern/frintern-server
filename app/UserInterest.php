<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    //

    protected $table = 'user_interest';
    protected $fillable = ['user_id', 'interest_id'];

    public function resources()
    {
        return $this->hasMany('App\Resource');
    }

    public function mentors()
    {
        return $this->belongsToMany('App\User', 'user_expertise', 'user_id');
    }

    public function mentees()
    {
        return $this->belongsToMany('App\User', 'user_interest', 'user_id');
    }
}
