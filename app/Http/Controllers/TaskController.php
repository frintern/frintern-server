<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Task;
use App\Program;
use App\User;

class TaskController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function store(Request $request)
    {
        try {
            $currentUser = JWTAuth::parseToken()->authenticate();
            $task = new Task();
            $task->program_id = $request->programId;
            $task->description = $request->description;
            $task->user_id = $currentUser['id'];
            $task->save();
            return response()->json($task, 201);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            return response()->json(['message' => $ex->getMessage()], 401);
        }
    }

    public function index(Request $request)
    {
        $tasks = Program::find($request->programId)
        ->tasks()->with('author')
        ->orderBy('tasks.created_at', 'DESC')->get();
        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = Task::with(['author', 'assignees' => function ($query) {
            return $query->orderBy('task_user.created_at', 'DESC');
        }])->where('tasks.id', $id)->first();
        return response()->json($task);
    }

    public function assignUser(Request $request)
    {
        $validator = Validator::make($request->only(['taskId', 'note', 'userId', 'dueDate']), [
            'taskId' => 'required|integer',
            'userId' => 'required|integer',
            'note' => 'sometimes|required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data']);
        }
        $assignee = [
            'task_id' => $request->taskId,
            'note' => $request->note,
            'due_date' => $request->dueDate,
        ];
        $user = User::find($request->userId);
        $task = Task::find($request->taskId)->assignees()->save($user, $assignee);
        // TODO: Notify the assignee about the task
        return response()->json(['message' => 'Success!'], 201);
    }

    public function submitResponse()
    {
        // TODO: save the response 

        // TODO: Notify the task creator
    }
}
