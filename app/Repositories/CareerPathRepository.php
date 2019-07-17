<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 4/22/16
 * Time: 7:00 AM
 */

namespace App\Repositories;

use App\Learner;
use App\CareerPathUser;

use Illuminate\Support\Facades\DB;

class CareerPathRepository
{



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

  

  
  

}