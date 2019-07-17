<?php

namespace App\Http\Controllers;

use App\Libraries\APIHandler;
use App\Question;
use App\Reply;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use App\Events\QuestionWasPosted;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class QuestionController extends Controller
{
    
    private $questionRepository;

    
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function getPublicQuestions()
    {
        $questions = Question::with(['author', 'directedTo', 'replies'])
            ->where('is_private', 0)
            ->orderBy('questions.created_at', 'DESC')->get();
        return response()->json($questions);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->only(['body', 'directedTo']),
            Question::rules()
            );

            if ($validator->fails()) {
                return APIHandler::response(0, $validator->errors(), [], 421);
            }
            $currentUser = JWTAuth::parseToken()->authenticate();

            $question = new Question();
            $question->asked_by = $currentUser['id'];
            $question->body = $request->get('body');
            $question->directed_to = $request->get('directedTo');
            $question->is_private = $request->get('isPrivate') ? $request->get('isPrivate') : 0;
            $question->created_at = \Carbon\Carbon::now();
            $question->save();
            $data['question'] = $question;
            event(new QuestionWasPosted($question));
            return APIHandler::response(1, "Question submitted", $data);
        } catch(JWTException $ex){
            return response()->json(['message' => $ex->getMessage()], 400);
        } 
    }
    
    
    /**
     * 
     */
    public function upvote($id)
    {
        $data['upvotes'] =$this->questionRepository->storeVote($id, auth()->user()->id, 1);

        return APIHandler::response(1, "Comment has been upvoted", $data);
    }

    /**
     * 
     */
    public function getQuestionsByProfile(Request $request)
    {
        try {
            if ($request->pageType == 'dashboard') {
                $query = Question::with(['author', 'directedTo', 'replies'])->where('is_private', 0);
            } else if ($request->askedBy == 'self') {
                $userId = JWTAuth::parseToken()->authenticate()['id'];
                $query = Question::with('author')->where('questions.asked_by', $userId);
            } else {
                $profileId = $request->get('directedTo') ? $request->directedTo : JWTAuth::parseToken()->authenticate()['id'];
                $query = Question::forTheCurrentUser($profileId)->with('author');
                if ($request->profileType == 'public') {
                    $query = $query->where('is_private', 0);
                }
            }
            
            $questions = $query->orderBy('questions.created_at', 'DESC')->get();
            return response()->json($questions, 200);  
        } catch(JWTException $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::with(['author', 'replies' => function($query){
            return $query->with('author')->orderBy('replies.created_at', 'DESC');
        }])->where('questions.id', $id)->first();
        return response()->json($question);
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
