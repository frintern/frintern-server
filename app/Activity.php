<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    //

    use SoftDeletes;

    /**
     * Used for soft deleting
     */
    protected $dates = ['deleted_at'];


    public static function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'task' => 'required|string',
            'online_resource' => 'string',
            'duration' => 'required|integer',
        ];
    }

    public function curriculums()
    {
        return $this->belongsToMany('App\Curriculum', 'curriculum_activities', 'curriculum_id', 'activity_id');

    }
}
