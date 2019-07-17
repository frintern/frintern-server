<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CareerPathAnswer extends Model
{
    public function question ()
    {
        return $this->belongsTo('App\CareerPathQuestion', 'career_path_question_id');
    }
}
