<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Invite extends Model
{
    //
    public static function rules()
    {
        return [
            'emails' => 'required|array'
        ];
    }

    public function validate(Request $request)
    {
        ['emails' => $request->get('emails')];
        $validator = Validator::make(['emails' => $request->get('emails')], $this->rules());

        return $validator;
    }
}
