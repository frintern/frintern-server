<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Question extends Model
{
    //
    use Eloquence;
    protected $searchableColumn = ['body', 'tags'];

    public static function rules()
    {
        return [
            'directedTo' => 'required|integer',
            'body' => 'required|string',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('comments.active', 1);
    }

    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }

    public function responses()
    {
        return $this->hasMany('App\Response');
    }

    public function scopeForTheCurrentUser($query, $userId)
    {
        return $query->where('questions.directed_to', $userId);
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'asked_by');
    }

    public function directedTo()
    {
        return $this->belongsTo('App\User', 'directed_to');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
