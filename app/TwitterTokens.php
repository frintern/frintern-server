<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterTokens extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'twitter_tokens';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['oauth_token','oauth_token_secret'];
}
