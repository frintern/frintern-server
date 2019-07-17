<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 4/22/16
 * Time: 7:00 AM
 */

namespace App\Repositories;


use App\Comment;
use Illuminate\Support\Facades\DB;

class CommentRepository
{
    private $comment;

    public function __construct()
    {
        $this->comment = new Comment();
    }

    public function store()
    {

    }

    public function storeVote($commentId, $userId, $type)
    {
        if ( !$this->voteExist($commentId, $userId) )
        {
            $commentVote = [
                'comment_id' => $commentId,
                'user_id' => $userId,
                'type' => $type,
                'created_at' => \Carbon\Carbon::now()
            ];

            DB::table('comment_votes')
                ->insert($commentVote);
        }

        $commentVotes = DB::table('comment_votes')
            ->where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->count();

        return $commentVotes;

    }

    public function voteExist($commentId, $userId)
    {
        return DB::table('comment_votes')
        ->where('comment_id', $commentId)
        ->where('user_id', $userId)
        ->exists();
    }
    
    public function getCommentsByResourceId($resourceId)
    {
        return $this->comment->join('users', 'comments.user_id', '=', 'users.id')
            ->select('comments.*', 'users.name as author', 'users.avatar_uri', DB::raw('DATE_FORMAT(comments.created_at, "%b %d, %Y") as date_created'))
            ->where('comments.resource_id', $resourceId)
            ->orderBy('comments.created_at', 'desc')
            ->get();
    }

}