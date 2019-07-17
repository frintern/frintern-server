<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 4/15/16
 * Time: 12:02 AM
 */

namespace App\Repositories;

use App\Resource;
use Illuminate\Support\Facades\DB;


/**
 * Class ResourceRepository
 * @package App\Repositories
 */
class ResourceRepository
{
    /**
     * @var Resource
     */
    private $resource;

    /**
     * ResourceRepository constructor.
     */
    public function __construct()
    {
        $this->resource = new Resource();
    }

    /**
     * @param $resourceId
     * @param $userId
     * @param $type
     * @return mixed
     */
    public function storeVote($resourceId, $userId, $type)
    {
        if (!$this->voteExist($resourceId, $userId) ) {
            $resourceVote = [
                'resource_id' => $resourceId,
                'user_id' => $userId,
                'type' => $type,
                'created_at' => \Carbon\Carbon::now()
            ];

            DB::table('resource_votes')
                ->insert($resourceVote);
        }

        $resourceVotes = DB::table('resource_votes')
            ->where('resource_id', $resourceId)
            ->where('user_id', $userId)
            ->count();

        return $resourceVotes;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getResourcesByUserId($userId)
    {
        return $this->resource->join('interests', 'resources.interest_id', '=', 'interests.id')
            ->leftJoin('resource_views', 'resources.id', '=', 'resource_views.resource_id')
            ->leftJoin('resource_votes', 'resources.id', '=', 'resource_votes.resource_id')
            ->leftJoin('comments', 'resources.id', '=', 'comments.resource_id')
            ->select('resources.id', 'resources.title', 'resources.content', DB::raw('DATE_FORMAT(resources.created_at, "%b %d, %Y") as created_at, COUNT(DISTINCT resource_views.id) as views, COUNT(DISTINCT resource_votes.id) as upvotes, COUNT(DISTINCT comments.id) as comments'), 'resources.featured_image_uri', 'interests.name as mentoring_area', 'resources.interest_id')
            ->where('resources.user_id', $userId)
            ->orderBy('resources.created_at', 'desc')
            ->groupBy('resources.id')
            ->get();

    }


    /**
     * @param $resourceId
     * @param $userId
     */
    public function storeView($resourceId, $userId)
    {
        if ( !$this->viewExist($resourceId, $userId) )
        {
            $resourceView = [
                'resource_id' => $resourceId,
                'user_id' => $userId,
                'created_at' => \Carbon\Carbon::now()
            ];

            DB::table('resource_views')
                ->insert($resourceView);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchResource($id)
    {
        return $this->resource->join('users', 'resources.user_id', '=', 'users.id')
            ->join('interests', 'resources.interest_id', '=', 'interests.id')
            ->leftJoin('resource_views', 'resources.id', '=', 'resource_views.resource_id')
            ->leftJoin('resource_votes', 'resources.id', '=', 'resource_votes.resource_id')
            ->leftJoin('comments', 'resources.id', '=', 'comments.resource_id')
            ->select('resources.id', 'resources.title', 'resources.content', DB::raw('DATE_FORMAT(resources.created_at, "%b %d, %Y") as created_at, COUNT(DISTINCT resource_views.id) as views, COUNT(DISTINCT resource_votes.id) as upvotes, COUNT(DISTINCT comments.id) as comments'), 'resources.featured_image_uri', 'interests.name as interest', 'users.name as author', 'resources.interest_id')
            ->where('resources.id', $id)
            ->first();
    }

    /**
     * Checks if a particular user has upvoted a particular resource
     * @param $resourceId
     * @param $userId
     * @return mixed
     */
    private function voteExist($resourceId, $userId)
    {
        return DB::table('resource_votes')
            ->where('resource_id', $resourceId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Check if a particular user has viewed a resource
     * @param $resourceId
     * @param $userId
     * @return mixed
     */
    private function viewExist($resourceId, $userId)
    {
        return DB::table('resource_views')
            ->where('resource_id', $resourceId)
            ->where('user_id', $userId)
            ->exists();
    }


    /**
     * 
     * @return mixed
     */
    public function fetchRecommendedResources()
    {
        return $this->resource->with(['author', 'upvotes'])
            ->orderBy('resources.created_at', 'DESC')
            ->limit(20)->get();
    }


    /**
     * Get resources related to a particular resource (resources in thesame mentoring area)
     * @param $resourceId
     * @param $mentoringAreaId
     * @return mixed
     */
    public function getResourcesRelatedTo($resourceId, $interestId)
    {
        return $this->resource->join('users', 'resources.user_id', '=', 'users.id')
            ->join('interests', 'resources.interest_id', '=', 'interests.id')
            ->select('resources.id', 'resources.title', 'resources.views', 'resources.content', 'users.name as author', DB::raw('DATE_FORMAT(resources.created_at, "%b %d, %Y") as created_at'), 'resources.featured_image_uri', 'interests.name as interest', 'resources.interest_id')
            ->where('interest_id', $interestId)
            ->where('resources.id', '!=', $resourceId)
            ->orderBy('resources.created_at', 'desc')->get();
    }


}