<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CareerPath;
use App\CareerPathQuestion;
use App\Admin;
use App\Learner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CareerPathSaved;
use \Darovi\LaravelSlackInvite\Slack;


class PathFinderController extends Controller
{
        
    public function listQuestions()
    {
        $careerPathQuestions = CareerPathQuestion::with('answers')->get();
        return $careerPathQuestions;
    }

    public function findPath(Request $request)
    {
        $dataPoints = $request->get('dataPoints');
        $dataPointsCategory = DB::table('career_path_answers')->select('career_path_category_id')->whereIn('id', $dataPoints)->get();
        $dataPointsCategory = collect($dataPointsCategory);
        $pluckedCategory = $dataPointsCategory->pluck('career_path_category_id');
        $pluckedCategory->all();
        $manageScore = count($pluckedCategory->filter(function ($value) { 
            return $value === 3;
        }));
        $designScore = count($pluckedCategory->filter(function ($value) { 
            return $value === 1;
        }));
        $analyzeScore = count($pluckedCategory->filter(function ($value) { 
            return $value === 2;
        }));

        $careerPathMapping = ['design' => 1, 'analyze' => 2, 'manage' => 3];
        $careerPathScore = array('manage' => $manageScore, 'design' => $designScore, 'analyze' => $analyzeScore);
        arsort($careerPathScore);
        $careerPathCategories = array_keys($careerPathScore);
        $matchedCareerPaths = DB::table('career_paths')->select('*')
            ->where('career_path_category_id', $careerPathMapping[array_values($careerPathCategories)[0]])->get();
        return ['score' => $careerPathScore, 'paths' => $matchedCareerPaths];
    }

    public function savePath(Request $request) 
    {
        $score = $request->get('score');
        $whatsAppNumber = $request->get('whatsAppNumber');
        $pathIds = array_pluck($request->get('paths'), 'id');
        $careerFits = implode(", ", array_pluck($request->get('paths'), 'name'));
        $paths = DB::table('career_paths')->select('name', 'description', 'learning_path_url')
            ->whereIn('id', $pathIds)->get();
        $email = $request->get('email');
        $fullName = $request->get('fullName');
        $slackNotificationData = [
            'email' => $email,
            'fullName' => $fullName,
            'careerFits' => $careerFits,
            'score' => $score,
            'whatsAppNumber' => $whatsAppNumber
        ];
        $this->createLearner($slackNotificationData);
      
        Notification::send(Admin::first(), new CareerPathSaved($slackNotificationData));
    }

    private function createLearner($learnerData)
    {
        $learner = new Learner();
        $learner->email = $learnerData['email'];
        $learner->career_fits = $learnerData['careerFits'];
        $learner->name = $learnerData['fullName'];
        $learner->whatsapp_number = $learnerData['whatsAppNumber'];
        $learner->manage_score = $learnerData['score']['manage'];
        $learner->design_score = $learnerData['score']['design'];
        $learner->analyze_score = $learnerData['score']['analyze'];
        $learner->save();
    }

    public function listSkillGuides() 
    {
        $skillGuides = CareerPath::all();
        return response()->json($skillGuides);
    }
    
}
