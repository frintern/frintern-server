<?php

namespace App\Http\Controllers;

use App\Libraries\APIHandler;
use App\Libraries\TokenHandler;
use App\Repositories\MenteeRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class MenteeController
 * @package App\Http\Controllers
 */
class MenteeController extends Controller
{
    //

    private $menteeRepository;

    public function __construct(MenteeRepository $menteeRepository)
    {
        $this->menteeRepository = $menteeRepository;
    }


    public function index()
    {
        $mentees = $this->menteeRepository->getAllMentees();
        return response()->json($mentees);
    }


    /**
     * Send mentoring request to mentors
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function sendMentoringRequest(Request $request)
    {
        $params = [
            'request_from' => $request->get('request_from'),
            'request_to' => $request->get('request_to'),
            'message' => $request->get('message'),
            'relationship' => $request->get('relationship'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ];

        $rules = [
            'request_from' => 'required|integer',
            'request_to' => 'required|integer',
            'message' =>  'string',
            'relationship' => 'string'
        ];

        $validator = Validator::make($params, $rules);
        if ($validator->fails()){
            return APIHandler::response(0, $validator->errors(), 400);
        }

        $requestId = DB::table('mentoring_requests')->insertGetId($params);

        $data = [
            'request_id' => $requestId
        ];


        return APIHandler::response(1, "Request has been sent", $data, 200);

    }

    /**
     * Cancel mentoring request
     * @param Request $request
     * @return $this
     */
    public function cancelMentoringRequest(Request $request)
    {
        // mentoring request ID
        $requestId = $request->get('request_id');
        DB::table('mentoring_request')->destroy($requestId);
        return APIHandler::response(1, "Your request has been cancelled");
    }

    /**
     * Get the mentors of a particular mentee
     * @param Request $request
     * @return $this
     */
    public function getMyMentors(Request $request)
    {
        $token = $request->header('token');
        $userData = TokenHandler::decode($token);
        $userId = $userData['id'];
        $data['mentors'] = DB::table('mentors_mentees')->where('mentee_id', $userId)->get();
        if (is_null($data['mentors'])){
            return APIHandler::response(0, "You do not have mentors, Find mentors", $data);
        }

        return APIHandler::response(1, "Your mentors", $data);
    }

    /**
     * Show a particular mentee
     * @param Request $request
     * @param $id
     */
    public function show(Request $request, $id)
    {

    }

    /**
     * Get programs taken by mentees
     * @param Request $request
     * @return $this
     */
    public function getMyPrograms(Request $request)
    {
        $user = TokenHandler::decode($request->header('token'));
        $data['programs'] = DB::table('mentee_programs')->where('user_id', $user['id']);
        return APIHandler::response(1, "Mentee's programs", $data);
    }

    public function getMenteesBySpecialization($specializationId)
    {
        $mentees = $this->menteeRepository->getMenteesBySpecialization($specializationId);
        return response()->json($mentees);
    }
}
