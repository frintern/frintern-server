<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillGuide extends Model
{
    public function careerPath()
    {
        return $this->belongsTo('App\CareerPath', 'career_path_id');
    }

    public function skillProgresses()
    {
        return $this->hasMany('App\SkillProgress', 'skill_guide_id');
    }
}
