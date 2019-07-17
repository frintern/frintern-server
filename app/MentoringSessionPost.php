<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class MentoringSessionPost extends Model
{
    //


    protected $fillable = ['text', 'mentoring_session_id', 'user_id'];

    public function rules ()
    {
        return [
            'mentoring_session_id' => 'required|integer',
            'text' => 'required|string'
        ];
    }

    public function validate($responseData)
    {
        return Validator::make($responseData, $this->rules());
    }

    public function author ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function upvotes()
    {
        return $this->morphMany('App\Upvote', 'upvotable');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }






}
