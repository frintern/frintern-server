<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MentoringSessionParticipant extends Model
{
    //

    public function mentoringSession ()
    {
        return $this->belongsTo('App\MentoringSession');
    }

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
