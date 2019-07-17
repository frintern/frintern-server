<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExpertise extends Model
{
    //
    protected $table = 'user_expertise';

    protected $fillable = ['id', 'user_id', 'mentor_id', 'interest_id', 'rating'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function interest()
    {
        return $this->belongsTo('App\Interest', 'interest_id');
    }
}
