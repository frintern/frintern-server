<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillProgress extends Model
{
    //
    public function careerPath()
    {
        return $this->belongTo('App\CareerPath', 'career_path_id');
    }

    public function skillGuide()
    {
        return $this->belongTo('App\SkillGuide', 'skill_guide_id');
    }
}
