<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Experience extends Model
{
    //
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'company_name', 'role', 'description', 'first_year', 'end_year', 'current'];


    private $rules = [
        'user_id' => 'required|integer',
        'company_name' => 'required|string',
        'role' => 'required|string',
        'description' => 'required|string',
        'first_year' => 'required',
        'end_year' => 'required'
    ];


    public function validate(array $experience)
    {
        return Validator::make($experience, $this->rules);
    }
}
