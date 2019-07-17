<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;


/**
 * Class Resource
 * @package App
 */
class Resource extends Model
{
    //
    use SoftDeletes;
    use Eloquence;

    protected $searchableColumns = ['content', 'tags'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * Validation rules for creating a new resource
     * @return array
     */
    public static function rules()
    {
        return [
            'content' => 'string',
            'user_id' => 'required|integer'
        ];
    }

    /**
     * Scope Mentoring Area
     * @param $query
     * @param $interestIds
     * @return mixed
     */
    public function scopeInterest($query, $interestIds)
    {
        return $query->whereIn('resources.interest_id', $interestIds);
    }

    public function getDates()
    {
        return [];
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    

    public function interest()
    {
        return $this->belongsTo('App\Interest');
    }


    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function upvotes()
    {
        return $this->morphMany('App\Upvote', 'upvotable');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program', 'program_resource');
    }
}
