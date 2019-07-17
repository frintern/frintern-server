<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 11/4/16
 * Time: 8:03 PM
 */

namespace App\Repositories;


use App\MentoringApplication;

/**
 * Class MentoringApplicationRepository
 * @package App\Repositories
 */
class MentoringApplicationRepository
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function fetchAllMentoringApplications()
    {
        $mentoringApplications =  MentoringApplication::with('user')->orderBy('mentoring_applications.created_at', 'desc')->get();
        return response()->json($mentoringApplications);
    }


    /**
     * Get mentor application by Id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getMentorApplicationById($id)
    {
        $application = MentoringApplication::with(['user' => function($query){
            $query->with(['expertise']);
        }])->where('id', $id)->first();

        return response()->json($application);
    }
}