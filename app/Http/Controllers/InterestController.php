<?php

namespace App\Http\Controllers;

use App\Libraries\APIHandler;
use App\Interest;
use App\User;
use App\Question;
use App\Program;
use App\Resource;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InterestController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->get('query');
        $matchedInterests = Interest::search($query)->get();
        $interestIds = collect($matchedInterests)->pluck('id');

        $mentors = count($interestIds) > 0 ? Interest::find($interestIds[0])
        ->experts()->with('expertise')->get() : [];
        $posts = Resource::search($query)->get();
        $programs = Program::with(['specialization', 'creator'])
        ->whereIn('specialization_id', $interestIds)->get();
        return response()->json([ 'mentors' => $mentors, 'programs' => $programs, 'posts' => $posts ]);
    }
    /**
     * Display a listing of interests: also called specializations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $interests = Interest::all();
        return response()->json($interests);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $interest = Interest::with(['programs', 'companies', 'experts', 'users' => function($q) {
            return $q->mentor();
        }])->where('id', $id)->first();
        return response()->json($interest);
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
