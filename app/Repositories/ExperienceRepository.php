<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 6/14/16
 * Time: 1:58 AM
 */

namespace App\Repositories;


use App\Experience;
use App\User;

class ExperienceRepository
{
    
    private $experience;
    
    public function __construct()
    {
        $this->experience = new Experience();
    }
    
    public function createOrUpdate(array $experience, $id = null)
    {
        $experience = $this->experience->updateOrCreate(['id' => $id], $experience);

        return $experience;
    }
    
    public function fetchExperienceByUserId($userId)
    {
        
        $experiences = User::find($userId)->experiences;
        
        return $experiences;
        
//        return $this->experience->where('experiences.user_id', $userId)->get();

    }

}