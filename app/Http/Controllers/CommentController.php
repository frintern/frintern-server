<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\CommentWasPosted;
use App\Libraries\APIHandler;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends Controller
{
    
    private $commentRespository;
    
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRespository = $commentRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authUser = JWTAuth::parseToken()->authenticate();
        //
        $validator = Validator::make($request->only(['resource_id', 'content']), Comment::rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 421);
        }

        $comment = new Comment();

        $comment->resource_id = $request->get('resource_id');
        $comment->user_id = $authUser['id'];
        $comment->content = $request->get('content');
        $comment->active = 1;
        $comment->root_id = $request->get('root_id');
        $comment->parent_id = $request->get('parent_id');
        $comment->created_at = \Carbon\Carbon::now();
        $comment->save();

        if ($comment->resource->user_id !== $comment->user_id) {
            // Notify author of resource
            event(new CommentWasPosted($comment));
        }

        return response()->json($comment);
    }
    
    public function upvote($id)
    {
        $authUser = JWTAuth::parseToken()->authenticate();
        $data['upvotes'] =$this->commentRespository->storeVote($id, $authUser['id'], 1);

        // Notify author of resource
        return APIHandler::response(1, "Comment has been upvoted", $data);
    }


    public function getComments($resourceId)
    {
        $data['comments'] = $this->commentRespository->getCommentsByResourceId($resourceId);
        return APIHandler::response(1, "Resource comments", $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
