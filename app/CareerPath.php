<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CareerPath extends Model
{
    public function skillGuides()
    {
        return $this->hasMany('App\SkillGuide', 'career_path_id');
    }

    public function skillProgresses()
    {
        return $this->hasManyThrough('App\SkillProgress', 'App\SkillGuide');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
