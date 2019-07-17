<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 9/27/16
 * Time: 12:45 AM
 */

namespace App\Repositories;


use App\Upvote;

class UpvoteRepository
{

    public function  __construct()
    {

    }

    public function saveUpvote($userId, $upvotableId, $upvotableType)
    {
        $upvote = new Upvote;
        $upvote->user_id = $userId;
        $upvote->upvotable_type = $upvotableType;
        $upvote->upvotable_id = $upvotableId;
        $upvote->updated_at = $upvote->created_at;
        $upvote->save();

        return $upvote;
    }

}