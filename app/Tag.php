<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //


    public function mentoringSessions()
    {
        return $this->morphedByMany('App\MentoringSession', 'taggable');
    }


    public function notes()
    {
        return $this->morphedByMany('App\Resource', 'taggable');
    }
}
