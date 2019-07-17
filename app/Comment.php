<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public static function rules()
    {
        return [
            'resource_id' => 'required|integer',
            'content' => 'required|string',
            'root_id' => 'integer',
            'parent_id' => 'integer'
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

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
