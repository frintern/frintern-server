<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Interest extends Model
{
    use Eloquence;

    protected $searchableColumns = ['name', 'description', 'skills', 'tags'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_interest');
    }

    public function programs()
    {
        return $this->hasMany('App\Program');
    }

    public function experts()
    {
        return $this->belongsToMany('App\User', 'user_expertise');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }

}
