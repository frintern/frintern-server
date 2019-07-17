<?php

namespace App\Http\Controllers;

use App\Reply;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Question;
use App\Events\ReplyWasPosted;
use Illuminate\Support\Facades\Validator;


class ReplyController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->only(['questionId', 'body']);
        $rules = [ 'questionId' => 'required|integer', 'body' => 'required|string'];
        $validator = Validator::make($params, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 421);
        }
        try {
            $reply = new Reply();
            $reply->question_id = $request->questionId;
            $reply->user_id = JWTAuth::parseToken()->authenticate()['id'];
            $reply->body = $request->body;
            $reply->save();
            event(new ReplyWasPosted($reply));

            return response()->json($reply);
        } catch(JWTException $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
