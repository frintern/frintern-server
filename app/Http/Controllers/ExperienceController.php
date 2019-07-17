<?php

namespace App\Http\Controllers;

use App\Experience;
use App\Libraries\APIHandler;
use App\Repositories\ExperienceRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExperienceController extends Controller
{
    
    
    private $experience;
    
    private $experienceRepository;
    
    
    public function __construct(ExperienceRepository $experienceRepository)
    {
        $this->experienceRepository = $experienceRepository;
        $this->experience = new Experience();
    }

    /**
     * Display a listing of the experiences that belongs to the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = JWTAuth::parseToken()->authenticate()['id'];

        return $this->experienceRepository->fetchExperienceByUserId($userId);

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
     * Store a newly created experience in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $experienceData = $request->all();
        $experienceData['user_id'] = JWTAuth::parseToken()->authenticate()['id'];
        $validator = $this->experience->validate($experienceData);
        if ($validator->fails()) {
            return APIHandler::response("0", $validator->errors());
        }
        $experience = $this->experienceRepository->createOrUpdate($experienceData);
        $data['experience']  = $experience;

        return APIHandler::response(1, "Experience created", $data);
    }


    public function getUserExperiences($userId)
    {
        $validator = Validator::make(['user_id' => $userId], ['user_id' => 'required|integer']);

        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), 401);
        }

        $data['educations'] = $this->experienceRepository->fetchExperienceByUserId($userId);

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
