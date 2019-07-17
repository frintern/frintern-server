<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Validator;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'name', 'account_type', 'user_name', 'email', 'password'];



    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];



    public function rules()
    {
        return [
            'accountType' => 'required|string',
            'firstName' => 'string',
            'lastName' => 'string',
            'name' => 'string',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8'
        ];

    }


    public function validate($userData)
    {
        return Validator::make($userData, $this->rules());
    }


    public function scopeFollowers($query, $userId)
    {
        return $query->where('follows.user_id', $userId);
    }

    public function scopeFollowings($query, $userId)
    {
        return $query->where('follows.followed_by', $userId);
    }

    public function scopeMentor($query)
    {
        return $query->where('users.is_a_mentor', 1);
    }

    public function scopeMentee($query)
    {
        return $query->where('users.is_a_mentor', 0);
    }

    public function scopeNotFollowing()
    {

    }

    public function scopeMatch($query, $interests, $currentUserId)
    {
        return $query
            ->whereIn('user_expertise.interest_id', $interests)
            ->where('users.id', '<>', $currentUserId);
    }

    public function mentor()
    {
        return $this->hasOne('App\Mentor');
    }
    
    public function educations()
    {
        return $this->hasMany('App\Education');
    }
    
    public function experiences()
    {
        return $this->hasMany('App\Experience');
    }

    public function expertise()
    {
        return $this->belongsToMany('App\Interest', 'user_expertise');
    }

    public function interests()
    {
        return $this->belongsToMany('App\Interest', 'user_interest');
    }

    public function resources()
    {
        return $this->hasMany('App\Resource');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }


    public function mentoringSessions ()
    {
        return $this->hasMany('App\MentoringSession');
    }

    public function mentorApplication ()
    {
        return $this->hasOne('App\MentoringApplication');
    }

    public function programs ()
    {
        return $this->belongsToMany('App\Program');
    }

    public function tasks()
    {
        return $this->belongsToMany('App\Task', 'task_user');
    }

    public function careerPaths()
    {
        return $this->belongsToMany('App\CareerPath');
    }
}
