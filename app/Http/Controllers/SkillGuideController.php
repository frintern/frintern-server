<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CareerPath;
use App\SkillGuide;
use App\User;
use App\SkillProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illumin\Support\Facades\Gate;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class SkillGuideController extends Controller
{

  public function getSkill(Request $request, $id)
  {
    $level = $request->get('level');
    $skill = CareerPath::with(['skillGuides' => function($query) { $query->orderBy('stage', 'asc'); }])->where('id', $id)->first();
    return response()->json($skill);
  }

  public function listSkills() 
  {
    $skills = CareerPath::all();
    return response()->json($skills);
  }

  public function saveSkillGuide(Request $request, $id)
  {
    try {
      $skillGuide = SkillGuide::find($id);
      $currentUser = JWTAuth::parseToken()->authenticate();
      $user = User::find($currentUser['id']);

      if (Gate::forUser($user)->denies('update-skill-guide', $skillGuide)) {
        return response()->json(['message' => 'Unauthorized action'], 401);
      }
      $skillGuide->content = $request->get('content');
      $skillGuide->save();
      return response()->json(['message' => 'Update Successful'], 200);
    } catch (ErrorException $ex) {
      return response()->json(['message' => 'Update Failed'], 401);
    }
  }

  public function getSkillGuide($id)
  {
    $skillGuide = SkillGuide::find($id);
    return response()->json($skillGuide);
  }

  public function listSkillGuides(int $id)
  {
    try {
      $currentUser = JWTAuth::parseToken()->authenticate();
      $skillGuides = SkillGuide::with(['careerPath', 'skillProgresses' => function($query) use ($currentUser){
        return $query->where('user_id', $currentUser['id']);
      }])->where('career_path_id', $id)->orderBy('stage', 'asc')->paginate(1);
      return response()->json($skillGuides);
    } catch (JWTException $ex) {
      $skillGuides = SkillGuide::with('careerPath')->where('career_path_id', $id)->orderBy('stage', 'asc')->paginate(1)->toArray();
      $skillGuides['data'][0]['skill_progresses'] = [];
      return response()->json($skillGuides);
    }
  }

  public function saveProgress(Request $request)
  {
    try {
      $currentUser = JWTAuth::parseToken()->authenticate();
      $skillGuideId = $request->get('skill_guide_id');
      $skillProgress = new SkillProgress;
      $skillProgress->user_id = $currentUser['id'];
      $skillProgress->skill_guide_id = $skillGuideId;
      $skillProgress->created_at = \Carbon\Carbon::now();
      $skillProgress->save();
      return response()->json(['message' => 'Progress saved']);
    } catch (JWTException $ex) {
      return response()->json(['message' => 'Progress could not be saved'], 401);
    }
  }

  public function getProgress()
  {
    try {
      $currentUser = JWTAuth::parseToken()->authenticate();
      $progress = CareerPath::withCount('skillGuides')->withCount(['skillProgresses' => function($query) use($currentUser) {
        return $query->where('skill_progresses.user_id', $currentUser['id']);
      }])->has('skillProgresses')->get();
      return response()->json($progress);
    } catch (JWTException $ex) {
      return response()->json(['message' => 'User not authenticated'], 401);
    } catch (TokenExpiredException $ex) {
      return response()->json(['message' => 'You need to login'], 401);
    }
  }
    
}
