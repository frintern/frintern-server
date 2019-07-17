<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class MentoringSession extends Model
{
    //

    protected $fillable = ['user_id', 'topic', 'description', 'mentoring_area_id'];


    public function rules ()
    {
        return [
            'user_id' => 'required|integer',
            'interest_id' => 'required|integer',
            'topic' => 'required|string',
            'description' => 'required|string',
//            'image_url' => 'required|string',

        ];
    }

    public function validate ($mentoringSession)
    {
        return Validator::make($mentoringSession, $this->rules());
    }

    public function participants ()
    {
        return $this->hasMany('App\MentoringSessionParticipant');
    }

    public function posts ()
    {
        return $this->hasMany('App\MentoringSessionPost');
    }

    public function interest ()
    {
        return $this->belongsTo('App\Interest');
    }

    public function creator ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');

    }

    public function scopeUpcoming($query)
    {

        return $query->where('end_time', '>=', \Carbon\Carbon::now());

    }

}
