<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    //
    
    use SoftDeletes;

    protected $table = 'educations';
    
    protected $dates = ['deleted_at'];
    
    protected $fillable = ['user_id', 'qualification', 'institution', 'course', 'first_year', 'grad_year'];
    
    private $rules = [
        'institution' => 'required|string',
        'course' => 'required|string',
        'qualification' => 'required|string',
        'first_year' => 'required',
        'grad_year' => 'required',
    ];
    
    
    public function validate(array $education)
    {
        return Validator::make($education, $this->rules);
    }
    
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
