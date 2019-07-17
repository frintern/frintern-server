<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Libraries\APIHandler;
use App\Libraries\TokenHandler;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * Class ActivityController
 * @package App\Http\Controllers
 */
class ActivityController extends Controller
{
    //

    /**
     * Create a new activity
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function create(Request $request)
    {
        // Get the user data from JWT
        $userData = TokenHandler::decode($request->header('token'));

        $activity = [
            'user_id' => $userData['id'],
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'task' => $request->get('task'),
            'online_resource' => $request->get('onlineResource'),
            'duration' => $request->get('duration'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ];

        $validator = Validator::make($activity, Activity::rules());

        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), 400);
        }

        try {
            Activity::insert($activity);
        } catch (\Exception $ex) {
            return APIHandler::response(0, "Unable to create activity.", 400);
        }


        return APIHandler::response(1, "Activity has been successfully created.", 201);
    }

    /**
     * Edit an existing activity
     * @param $id
     * @return \App\Libraries\Response
     */
    public function edit($id)
    {
        $validator  = Validator::make(['id' => $id], ['id' => 'required|integer']);

        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), 400);
        }

        $activity = Activity::find($id);

        return APIHandler::response(1, "Activity", $activity);
    }

    /**
     * Update an existing activity
     * @param Request $request
     * @param $id
     * @return \App\Libraries\Response
     */
    public function update(Request $request, $id)
    {
        $updates = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'task' => $request->get('task'),
            'online_resource' => $request->get('onlineResource'),
            'duration' => $request->get('duration'),
            'updated_at' => \Carbon\Carbon::now()
        ];

        $validator = Validator::make($updates, Activity::rules());

        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), 400);
        }

        try {
            Activity::where('id', $id)->update($updates);
        } catch (\Exception $ex) {
            return APIHandler::response(0, $ex->getMessage(), 400);
        }

        return APIHandler::response(1, "Activity has been successfully updated");
    }

    /**
     * Soft delete activity
     * @param $id
     * @return \App\Libraries\Response
     */
    public function destroy($id)
    {
        Activity::destroy($id);

        return APIHandler::response(1, "Activity has been successfully deleted");
    }

    /**
     * Get all activities created by a particular user
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function getActivities(Request $request)
    {

        $token = $request->header('token');

        $userData = TokenHandler::decode($token);

        $activities = Activity::select('*')->where('user_id', $userData['id']);

        return APIHandler::response(1, "All activities", $activities);
    }
}
