<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    //
    protected $fillable = ['mentor_id', 'title', 'description', 'specialization_id', 'is_public', 'is_active', 'logo_uri'];


    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function rules()
    {
        return [
            'created_by' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
            'is_public' => 'required',
            'specialization_id' => 'required|integer',
            'logo_uri' => 'string'
        ];
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function mentors()
    {
        return $this->belongsToMany('App\User', 'mentor_program', 'program_id', 'mentor_id')->withPivot('is_active');
    }

    public function mentees()
    {
        return $this->belongsToMany('App\User', 'mentee_program', 'program_id', 'mentee_id')->withPivot('is_active');
    }

    public function creator ()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function specialization ()
    {
        return $this->belongsTo('App\Interest', 'specialization_id');
    }

    public function resources()
    {
        return $this->belongsToMany('App\Resource', 'program_resource', 'program_id', 'resource_id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

}
