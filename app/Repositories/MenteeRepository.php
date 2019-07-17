<?php
/**
 * Created by PhpStorm.
 * User: Jidesakin
 * Date: 31/03/2017
 * Time: 05:44
 */

namespace App\Repositories;


use App\Interest;
use App\User;

class MenteeRepository
{

    public function getMenteesBySpecialization($specializationId)
    {
        $mentees = Interest::find($specializationId)->mentees()
        ->where('users.is_a_mentor', 0)
        ->where('users.account_type', 'individual')
        ->get();
        return $mentees;
    }

    public function getAllMentees()
    {
        return User::mentee()->with('interests')->get();
    }

}