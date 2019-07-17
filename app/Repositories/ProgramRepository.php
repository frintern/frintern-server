<?php
/**
 * Created by PhpStorm.
 * User: Jidesakin
 * Date: 30/03/2017
 * Time: 11:01
 */

namespace App\Repositories;


use App\Program;
use Illuminate\Support\Facades\DB;

class ProgramRepository
{
    public function __construct()
    {

    }

    public function createOrUpdate ($programData, $id = null)
    {
        $program = is_null($id) ? new Program() : Program::find($id);
        $program->title = $programData['title'];
        $program->Description = $programData['description'];
        $program->created_by = $programData['created_by'];
        $program->logo_uri = $programData['logo_uri'];
        $program->is_public = $programData['is_public'];
        $program->specialization_id = $programData['specialization_id'];
        $program->updated_at = $program->created_at = \Carbon\Carbon::now();
        $program->save();
        return $program;
    }

    public function inviteMentor($programMentor)
    {
        DB::table('program_mentor')->insert($programMentor);
    }

    public function inviteMentee($programMentee)
    {
        DB::table('program_mentee')->insert($programMentee);
    }

    public function acceptMentorInvitation()
    {

    }

    public function acceptMenteeInvitation()
    {

    }


    /**
    * Adds list of mentors to the program
    * @param $id
    * @param $mentors
    */
    public function addMentorsToProgram($id, $mentors) 
    {
        foreach($mentors as $mentor) {
            DB::table('mentor_program')->insert([
                'program_id' => $id,
                'mentor_id' => $mentor,
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }

    public function addMenteesToProgram($id, $mentees)
    {
        foreach($mentees as $mentee) {
            DB::table('mentee_program')->insert([
                'program_id' => $id,
                'mentee_id' => $mentee,
                'is_active' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }

}