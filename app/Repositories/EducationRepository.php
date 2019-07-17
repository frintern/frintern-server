<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 6/14/16
 * Time: 1:57 AM
 */

namespace App\Repositories;


use App\Education;
use App\User;

class EducationRepository
{
    
    private $education;
    
    public function __construct()
    {
     
        $this->education = new Education();
    }

    public function createOrUpdate(array $education, $id = null)
    {
        $education = $this->education->updateOrCreate(['id' => $id], $education);
        
        return $education;
    }
    
    public function fetchEducationByUserId($userId)
    {
        $educations = User::find($userId)->educations;
        
        return $educations;
        
    }

}