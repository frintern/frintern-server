<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 11/6/16
 * Time: 11:21 PM
 */

namespace App\Repositories;


use App\UserExpertise;
use Illuminate\Support\Facades\DB;

class UserExpertiseRepository
{
    private $expertiseArea;

    public function __construct()
    {
        $this->expertiseArea = new UserExpertise();
    }

    public function saveExpertise($expertiseArray, $userId)
    {
        DB::table('user_expertise')->where('user_id', $userId)
            ->delete();

        foreach($expertiseArray as $expertise) {
            DB::table('user_expertise')->insert(['user_id' => $userId, 'interest_id' => $expertise['id'], 'rating' => $expertise['rating']]);
        }
    }

}