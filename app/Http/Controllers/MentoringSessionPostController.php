<?php

namespace App\Http\Controllers;

use App\Events\SessionPostWasSubmitted;
use App\MentoringSessionPost;
use App\Repositories\MentoringSessionPostRepository;
use App\Repositories\UpvoteRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class MentoringSessionPostController extends Controller
{

    private $mentoringSessionPostRepository;

    private $mentoringSessionPost;

    private $upvoteRepository;


    public function __construct(MentoringSessionPostRepository $mentoringSessionPostRepository, UpvoteRepository $upvoteRepository)
    {

        $this->mentoringSessionPostRepository = $mentoringSessionPostRepository;
        $this->mentoringSessionPost = new MentoringSessionPost();
        $this->upvoteRepository = $upvoteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $postData = $request->only(['text', 'mentoring_session_id']);
        $postData['user_id'] = JWTAuth::parseToken()->authenticate()['id'];
        $validator = $this->mentoringSessionPost->validate($postData);

        if ( $validator-> fails() ) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $post = $this->mentoringSessionPostRepository->createOrUpdate($postData);

        // Notify participants
//        event(new SessionPostWasSubmitted($post));

        return response()->json(compact('post'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return a post with all the replies
        $post = MentoringSessionPost::with(['replies' => function ($query) {
            $query->with('author');
        }])->where('id', $id)->first();

        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function upvote(Request $request)
    {
        $currentUserId = JWTAuth::parseToken()->authenticate()['id'];

        $id = $request->get('id');

        $this->upvoteRepository->saveUpvote($currentUserId, $id, 'App\MentoringSessionPost');
    }
}
