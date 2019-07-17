<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 4/22/16
 * Time: 11:02 PM
 */

namespace App\Repositories;


use App\Question;
use Illuminate\Support\Facades\DB;

class QuestionRepository
{
    
    private $question;
    
    public function __construct()
    {
        $this->question = new Question();
    }
    

    public function storeVote($questionId, $userId, $type)
    {
        if ( !$this->voteExist($questionId, $userId) )
        {
            $questionVote = [
                'question_id' => $questionId,
                'user_id' => $userId,
                'type' => $type,
                'created_at' => \Carbon\Carbon::now()
            ];

            DB::table('question_votes')
                ->insert($questionVote);
        }

        $questionVotes = DB::table('question_votes')
            ->where('question_id', $questionId)
            ->where('user_id', $userId)
            ->count();

        return $questionVotes;

    }

    public function voteExist($questionId, $userId)
    {
        return DB::table('question_votes')
            ->where('question_id', $questionId)
            ->where('user_id', $userId)
            ->exists();
    }
}