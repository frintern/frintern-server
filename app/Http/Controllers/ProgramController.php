<?php

namespace App\Http\Controllers;

use App\Events\InviteMenteeToProgram;
use App\Events\InviteMentorToProgram;
use App\Events\UserJoinedProgram;
use App\Program;
use App\Libraries\APIHandler;
use App\Libraries\TokenHandler;
use App\Repositories\ProgramRepository;
use App\User;
use App\MentorProgram;
use App\MenteeProgram;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class ProgramController
 * Programs are created by mentors for mentees
 * @package App\Http\Controllers
 */
class ProgramController extends Controller
{
    //

    private $programRepository;

    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
    }


    public function index()
    {
        $programs = Program::with(['specialization', 'creator', 'mentors', 'mentees'])->get();
        return response()->json($programs);
    }

    public function show($id)
    {
        $program = Program::with(['creator', 'mentors', 'mentees', 'specialization'])
        ->where('id', $id)->first();
        try {
            $currentUser = JWTAuth::parseToken()->authenticate();
            $program->status = $this->getUserProgramStatus($id, $currentUser['id']);
        } catch(JWTException $ex ) {
            $program->status = ['role' => null, 'is_active' => 0];
        }
        return response()->json($program);
    }


    /**
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function store(Request $request)
    {
        try {
            $currentUser = JWTAuth::parseToken()->authenticate();
            $programData = [
                'created_by' => $currentUser['id'],
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'is_public' => $request->get('is_public'),
                'specialization_id' => $request->get('specialization_id'),
                'logo_uri' => $request->get('logo_uri'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ];

            $validator = Validator::make($programData, Program::rules());

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $program = $this->programRepository->createOrUpdate($programData);
            $this->programRepository->addMentorsToProgram($program->id, [$currentUser['id']]);
           
            return response()->json(['message' => 'Your Mentorship Program has been created.', 'program' => $program]);
        } catch (JWTException $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }

    /**
     * Edit an existing program
     * @param $id
     * @return \App\Libraries\Response
     */
    public function edit($id)
    {
        $rules = [
            'id' => 'required|integer'
        ];
        $validator = Validator::make(['id' => $id], $rules);
        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors());
        }

        $program = Program::find($id);
        $activities = $program->activities();

        $data = [
            'program' => $program,
            'activities' => $activities
        ];

        return APIHandler::response(1, "Edit Program", $data);
    }

    /**
     * Update an existing program
     * @param Request $request
     * @param $id
     * @return \App\Libraries\Response
     */
    public function update(Request $request, $id)
    {
        $updates = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'updated_at' => \Carbon\Carbon::now()
        ];

        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
        ];

        $validator = Validator::make($updates, $rules);

        if ($validator->fails())
        {
            return APIHandler::response(0, $validator->errors(), 400);
        }

        Program::where('id', $id)->update($updates);

        return APIHandler::response(1, "Program has been updated");

    }

    /**
     *  Get all the programs created by a specified user (mentor)
     * @param Request $request
     * @return \App\Libraries\Response
     */
    public function getUserPrograms(Request $request)
    {
        $userData = TokenHandler::decode($request->header('token'));
        $programs = Program::select('*')->where('user_id', $userData['id']);
        $data = [
            'programs' => $programs
        ];

        return APIHandler::response(1, "User Programs", $data);
    }

    /**
     * @param $id
     * @return \App\Libraries\Response
     */
    public function destroy($id)
    {
        Program::destroy($id);
        return APIHandler::response(1, "Program has been successfully deleted");
    }

    public function inviteMentor(Request $request)
    {
        $params = $request->only(['program_id', 'mentor_id']);
        $validator = Validator::make($params, [
            'program_id' => 'required|integer',
            'mentor_id' => 'required|integer|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $mentorExist = DB::table('mentor_program')
            ->where('program_id', $params['program_id'])
            ->where('mentor_id', $params['mentor_id'])
            ->exists();

        if ($mentorExist) {
            return response()->json(['message' => 'Mentor already exist'], 409);
        }

        $params['updated_at'] = $params['created_at'] = \Carbon\Carbon::now();
        $params['is_active'] = 0;
        $program = Program::find($params['program_id']);
        $program->mentors()->attach($params['mentor_id']);
        $mentor = User::find($params['mentor_id']);

        // Send email notification to mentor
        event(new InviteMentorToProgram($program, $mentor));

        return response()->json(['message' => 'Invitation was sent']);

    }

    public function inviteMentee(Request $request)
    {
        $params = $request->only(['program_id', 'mentee_id']);
        $validator = Validator::make($params, [
            'program_id' => 'required|integer',
            'mentee_id' => 'required|integer|exists:users,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $menteeExist = DB::table('mentee_program')
            ->where('program_id', $params['program_id'])
            ->where('mentee_id', $params['mentee_id'])
            ->exists();

        if ($menteeExist) {
            return response()->json(['message' => 'Mentee already exist'], 409);
        }

        $program = Program::find($params['program_id']);
        $program->mentees()->attach($params['mentee_id']);

        $mentee = User::find($params['mentee_id']);
        event(new InviteMenteeToProgram($program, $mentee));

        return response()->json(['message' => 'Invitation was sent']);
    }

    public function join(Request $request, $id)
    {
        try {
            $currentUser = JWTAuth::parseToken()->authenticate();
            $params = $request->only(['invitation_id', 'invitation_type']);
            $params['program_id'] = $id;
            $validator = Validator::make($params, [
                'program_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $program = Program::with('creator')
            ->where('id', $params['program_id'])->first();
            $invitee = User::find($currentUser['id']);
            $params['invitation_type'] == 'mentor' ? 
            $this->joinAsMentor($params['program_id'], $currentUser['id']) : 
            $this->joinAsMentee($params['program_id'], $currentUser['id']);

            event(new UserJoinedProgram($program, $invitee));
            return response()->json(['message' => 'Your request has been sent']);
        } catch (JWTException $ex) {
            return response()->json(['message' => $ex->getMessage(), 'statusCode' => 400], 400);
        }

    }

    public function getResources($id)
    {
        $resources = Program::find($id)->resources()->with('author')->orderBy('resources.created_at', 'DESC')->get();
        return response()->json($resources);
    }

    public function getMentors($id)
    {
        $mentors = Program::find($id)->mentors;
        return response()->json($mentors);
    }

    public function getMentees($id)
    {
        $mentees = Program::find($id)->mentees;
        return response()->json($mentees);
    }

    private function joinAsMentor($id, $userId)
    {
        $mentorProgram = MentorProgram::where([
            'mentor_id' => $userId,
            'program_id' => $id,
        ])->exists() 
        ? MentorProgram::where('mentor_id', $userId)->first() : 
        new MentorProgram();
        $mentorProgram->mentor_id = $userId;
        $mentorProgram->is_active = 1;
        $menteeProgram->program_id = $id;
        $mentorProgram->save();
        return $mentorProgram;
    }

    private function joinAsMentee($id, $userId)
    {
        $menteeProgram = MenteeProgram::where([
            'mentee_id' => $userId,
            'program_id' => $id,
            ])->exists() ? 
            MenteeProgram::where('mentee_id', $userId)->first() : 
            new MenteeProgram();
        $menteeProgram->mentee_id = $userId;
        $menteeProgram->is_active = 1;
        $menteeProgram->program_id = $id;
        $menteeProgram->save();
        return $menteeProgram;
    }


    private function getUserProgramStatus($id, $userId)
    {
        $isAMentee = MenteeProgram::where([
            'mentee_id' => $userId,
            'program_id' => $id,
            ])->first();
        $isAMentor = MentorProgram::where([
                'mentor_id' => $userId,
                'program_id' => $id,
            ])->first();
        if ($isAMentee) {
            return ['role' => 'mentee', 'is_active' => $isAMentee->is_active];
        }
        if ($isAMentor) {
            return ['role' => 'mentor', 'is_active' => $isAMentor->is_active];
        }
        return ['role' => null, 'is_active' => 0];
    }
}
