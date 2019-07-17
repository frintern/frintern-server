<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //

    public function rules()
    {
        return [
            'text' => 'required|string',
            ''
        ];
    }


    public function author ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function question()
    {
        return $this->belongsTo('App\Question', 'question_id');
    }
}
