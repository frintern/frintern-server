<?php

namespace App\Http\Controllers;

use App\Relationship;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;


class RelationshipController extends Controller
{

    private $relationship;


    public function __construct()
    {
        $this->relationship = new Relationship();
    }


    public function add(Request $request)
    {
        $params = $request->only(['receiver_id', 'relationship_type_id']);

        $params['sender_id'] = JWTAuth::parseToken()->authenticate()['id'];

        $validator = $this->relationship->validate($params);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }


        $relationship = new Relationship();

        $relationship->sender_id = $params['sender_id'];
        $relationship->receiver_id = $params['receiver_id'];
        $relationship->relationship_type_id = $params['relationship_type_id'];
        $relationship->status = 0;

        $relationship->save();


        return response()->json($relationship, 200);

    }

    public function approve($receiverId)
    {

    }



}
