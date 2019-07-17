<?php

namespace App\Http\Controllers;

use App\Education;
use App\Libraries\APIHandler;
use App\Repositories\EducationRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class EducationController extends Controller
{

    private $education;
    private $educationRepository;


    public function __construct(EducationRepository $educationRepository)
    {
        $this->middleware('jwt.auth');
        $this->educationRepository = $educationRepository;
        $this->education = new Education();
    }

    /**
     * Display a listing of the auth user educations
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $userId = $currentUser['id'];
        
        return $this->educationRepository->fetchEducationByUserId($userId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $educationData = $request->all();

        $educationData['user_id'] = JWTAuth::parseToken()->authenticate()['id'];

        // validate inputs
        $validator = $this->education->validate($request->all());

        if ($validator->fails())
        {
            return APIHandler::response("0", $validator->errors());

        }
        
        $education = $this->educationRepository->createOrUpdate($educationData);

        $data['education']  = $education;

        return APIHandler::response(1, "Education created", $data);

    }

    public function getUserEducations(int $userId)
    {
        $validator = Validator::make(['user_id' => $userId], ['user_id' => 'required|integer']);

        if ($validator->fails())
        {
            return APIHandler::response(0, $validator->errors(), 401);
        }

        $data['educations'] = $this->educationRepository->fetchEducationByUserId($userId);

        return APIHandler::response(1, "User Educations", $data);
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
        // Check if the auth user is authorized to view this education
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
        // Check if the auth user is authorized to update this education
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if the auth user is authorized to delete this education

    }
}
