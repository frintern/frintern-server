<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Relationship extends Model
{
    //

    public function rules()
    {
        return [
            'sender_id' => 'required|integer',
            'receiver_id' => 'required|integer',
            'relationship_type_id' => 'required|integer'
        ];
    }

    public function validate($relationshipData)
    {
        return Validator::make($this->rules(), $relationshipData);
    }
}
