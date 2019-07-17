<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CareerPathQuestion extends Model
{
    public function answers ()
    {
        return $this->hasMany('App\CareerPathAnswer', 'career_path_question_id');
    }
}
