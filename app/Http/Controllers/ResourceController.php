<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Libraries\APIHandler;
use App\Libraries\TokenHandler;
use App\Question;
use App\Resource;
use App\Program;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ResourceRepository;
use App\Repositories\UpvoteRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Events\NewLearningPathResourcePublished;


/**
 * Class ResourceController
 * @package App\Http\Controllers
 */
class ResourceController extends Controller
{

    private $resourceRepository;
    private $upvoteRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->middleware('jwt.auth', ['except' => ['getTopStories']]);
        $this->resourceRepository = $resourceRepository;
        $this->upvoteRepository = new UpvoteRepository();
    }

    public function getTopStories()
    {
        $topStories = $this->resourceRepository->fetchRecommendedResources();
        return response()->json($topStories);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'image_link' => 'sometimes|url',
        ]);

        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), [], 400);
        }

        $resource = new Resource;
        $resource->user_id = $currentUser['id'];
        $resource->title = $request->get('title');
        $resource->content = $request->get('content');
        $resource->image_link = $request->get('imageLink');
        $resource->video_link = $request->get('videoLink');
        $resource->file_link = $request->get('fileLink');
        $resource->audio_link = $request->get('audioLink');
        $resource->tags = collect($request->get('tags'))->implode('text', ',');
        $resource->is_public = 0;
        $resource->save();
        $data['resource'] = $resource;

        if ($request->get('programId')) {
           $this->addToProgram($resource, $request->programId);
        //    event(new NewLearningPathResourcePublished($resource, $invitee));
        }

        User::find($currentUser['id'])->increment('points', 2);

        return APIHandler::response(1, "New resource has been created", $data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $rules = [
            'id' => 'required|integer'
        ];

        $validator = Validator::make(['id' => $id], $rules);
        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), 400);
        }
        $resource = $this->resourceRepository->fetchResource($id);
        $this->resourceRepository->storeView($id, $currentUser['id']);

        $data = [
            'resource' => $resource,
            'related_resources' => $this->resourceRepository->getResourcesRelatedTo($resource->id, $resource->mentoring_area_id)
        ];

        return APIHandler::response(1, "Show Resource", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rules = [
            'id' => 'required|integer'
        ];

        $validator = Validator::make(['id' => $id], $rules);
        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), 400);
        }

        $resource = Resource::find($id);
        $data = [
            'resource' => $resource,
        ];

        return APIHandler::response(1, "Edit Resource", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'mentoring_area_id' => 'required|integer',
            'featured_image_uri' => 'string',
        ]);

        if ($validator->fails()) {
            return APIHandler::response(0, $validator->errors(), 400);
        }
        
        $resource = Resource::find($id);
        $resource->title = $request->get('title');
        $resource->content = $request->get('content');
        $resource->featured_image_uri = $request->get('featured_image_uri');
        $resource->updated_at = \Carbon\Carbon::now();
        $resource->mentoring_area_id = $request->get('mentoring_area_id');
        $resource->save();
        $data['resource'] = $resource;
        return APIHandler::response(1, "Resource has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Resource::destroy($id);
        return APIHandler::response(1, "Resource has been successfully deleted");
    }


    /**
     * Get recommeded resources/articles/resources for the dashboard based on users interest
     * @return \App\Libraries\Response
     */
    public function getRecommendedResources()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $interestIds = DB::table('user_interest')
            ->select('interest_id')
            ->where('user_id', $currentUser['id'])->get();
        $userInterestIds = collect($interestIds)->pluck('interest_id')->all();
        $recommendedResources = $this->resourceRepository->fetchRecommendedResources();

        return $recommendedResources;
    }

    /**
     * Returns the resources of the authenticated user
     * @return \App\Libraries\Response
     */
    public function myResources()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data['resources'] = $this->resourceRepository->getResourcesByUserId($currentUser['id']);
        return APIHandler::response(1, "My Resources", $data);
    }


    public function getComments($id)
    {
        $data['comments'] = Comment::join('users', 'comments.user_id', '=', 'users.id')
            ->leftJoin('comment_votes', 'comments.id', '=', 'comment_votes.comment_id')
            ->select('comments.*', 'users.name as author', 'users.avatar_uri', DB::raw('DATE_FORMAT(comments.created_at, "%b %d, %Y") as date_created, COUNT(comment_votes.id) as upvotes'))
            ->where('comments.resource_id', $id)
            ->orderBy('comments.created_at', 'desc')
            ->groupBy('comments.id')
            ->get();

        return APIHandler::response(1, "Resource comments", $data);
    }

    public function getQuestions($id)
    {
        $data['questions'] = Question::join('users', 'questions.user_id', '=', 'users.id')
            ->leftJoin('question_votes', 'questions.id', '=', 'question_votes.question_id')
            ->select('questions.*', 'users.name as author', 'users.avatar_uri', DB::raw('DATE_FORMAT(questions.created_at, "%b %d, %Y") as date_created, COUNT(question_votes.id) as upvotes'))
            ->where('questions.resource_id', $id)
            ->orderBy('questions.created_at', 'desc')
            ->groupBy('questions.id')
            ->get();

        return APIHandler::response(1, "Resource questions", $data);
    }

    public function upVote($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data['id'] = $id;
        $data['upvotes'] = $this->upvoteRepository->saveUpvote($currentUser['id'], $id, 'App\Resource');
        $data['voter'] = $currentUser;
        $data['author'] = $this->getAuthorByResourceId($id)[0];
        $data['resource'] = Resource::find($id);

        Mail::send('emails.upvote', ['data' => $data], function($message) use($data){
            $message->from('notification@meetrabbi.com', 'Meetrabbi Notifications');
            $message->to($data['author']->email, $data['author']->first_name . " " . $data['author']->last_name);
            $message->subject($data['voter']->first_name . " " . $data['voter']->last_name . " upvoted your post on MeetRabbi!");
        });

        return APIHandler::response(1, "You voted up", $data);
    }
    
    public function getAuthorByResourceId($id)
    {
        return Resource::join('users', 'resources.user_id', '=', 'users.id')
            ->select('users.*')
            ->where('resources.id', $id)
            ->get();
    }

    public function getVotes($id)
    {

    }
    
    public function addToProgram(Resource $resource, $programId) {
        $program = Program::find($programId);
        $createdAt = \Carbon\Carbon::now();
        $program->resources()->save($resource, ['created_at' => $createdAt]);
        $program->save();
    }

}
