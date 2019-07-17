<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function assignees()
    {
        return $this->belongsToMany('App\User', 'task_user');
    }
}
