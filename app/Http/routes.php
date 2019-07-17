<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('api', function() {
   return response()->json(['message' => 'Welcome to Meetrabbi API']);
});

// General User Endpoints
Route::get('/', ['middleware' => 'guest', function () {
    return view('index');
}]);


Route::group(['prefix' => 'api'], function(){

    // Authentication Collection
    Route::post('/auth/login', 'AuthController@authenticate');
    Route::get('/auth/user', 'UserController@getPrivateUserProfile');
    Route::post('/auth/register', 'AuthController@register');
    Route::post('/auth/facebook', 'AuthController@facebook');
    Route::post('/auth/twitter', 'AuthController@twitter');
    Route::post('/auth/linkedin', 'AuthController@linkedin');

    Route::get('/auth/unlink/{provider}', ['middleware' => 'auth', 'uses' => 'AuthController@unlink']);
    Route::any('/auth/verify_account', 'AuthController@verify');
    Route::post('/auth/resend_code', 'AuthController@resendVerificationCode');

    Route::post('/password/confirm_reset', 'PasswordController@confirmResetPassword');
    Route::post('/password/reset', 'PasswordController@resetPassword');
    Route::post('/refresh_token', 'AuthController@verifyPasswordReset');

    /* User Collection */

    Route::get('/users/{id}/profile/public', 'UserController@getPublicUserProfile');
    Route::post('/user/onboard', 'UserController@onBoard');
    Route::post('/user/profile/basic/update', 'UserController@updateBasicProfile');
    Route::post('/user/interests/update', 'UserController@updateInterests');
    Route::get('/user/expertise', 'UserController@getExpertise');
    Route::get('/user/password/check', 'UserController@isUserPasswordSet');
    Route::post('/user/password/set', 'UserController@setPassword');
    Route::post('/user/education', 'UserController@updateEducation');
    Route::post('/user/profile_picture/update', 'UserController@updateProfilePicture');
    Route::post('/user/cover_photo/update', 'UserController@updateCoverPhoto');

    /* Resource Collection */

    Route::post('resources', 'ResourceController@store');
    Route::post('resource/viewed', 'ResourceController@incrementViews');
    Route::get('resources/{id}', 'ResourceController@show');
    Route::put('resources/{id}', 'ResourceController@update');
    Route::delete('resources/{id}', 'ResourceController@destroy');
    Route::get('resources', 'ResourceController@getRecommendedResources');
    Route::get('resource/top', 'ResourceController@getTopStories');
    Route::get('resource/related', 'ResourceController@getRelatedResources');
    Route::get('resources/{id}/comments', 'ResourceController@getComments');
    Route::get('resources/{id}/questions', 'ResourceController@getQuestions');
    Route::post('resources/{id}/update', 'ResourceController@update');


    /* Follows Collection */

    Route::post('user/follow', 'UserController@follow');
    Route::post('user/unfollow', 'UserController@unfollow');
    Route::get('/specializations', 'InterestController@index');
    Route::get('people', 'UserController@getAllUsers');
    Route::get('users/{id}/followers', 'UserController@followers');
    Route::get('users/{id}/following', 'UserController@following');
    Route::get('user/followers', 'UserController@authFollowers');
    Route::get('user/following', 'UserController@authFollowing');
    Route::get('me/resources', 'ResourceController@myResources');
    Route::get('user/interests', 'UserController@getAreasOfInterest');
    Route::get('mentors/matched', 'MentorController@getMatchedMentors');


    /* Comments Collection */

    Route::post('/comments', 'CommentController@store');
    Route::post('/comments/{id}/upvote', 'CommentController@upvote');


    /* Questions Collection */

    Route::post('questions', 'QuestionController@store');
    Route::post('questions/{id}/upvote', 'QuestionController@upvote');
    Route::get('questions', 'QuestionController@getQuestionsByProfile');
    Route::get('questions/{id}', 'QuestionController@show');
    Route::get('public/questions', 'QuestionController@getPublicQuestions');

    /* Invite Collection */

    Route::post('/invites', 'InviteController@sendInvite');


    /* Votes Collection */

    Route::get('/resources/{id}/votes', 'ResourceController@getVotes');
    Route::post('/resources/{id}/upvote', 'ResourceController@upVote');


    /* Interest Collection */

    Route::resource('/interests', 'InterestController');


    /* Mentors Collection */

    Route::get('/mentors', 'MentorController@index');
    Route::get('/mentors/featured', 'MentorController@getFeaturedMentors');
    Route::post('/mentor/application/submit', 'MentorController@submitApplication');
    Route::post('/mentor/expertise/update', 'MentorController@updateExpertise');
    Route::get('/mentors/auth/follow', 'MentorController@getMentorsYouFollow');
    Route::get('/specializations/{id}/mentors', 'MentorController@getMentorsBySpecialization');
    Route::get('/specializations/{id}/mentees', 'MenteeController@getMenteesBySpecialization');
    Route::post('/mentor/nominate', 'MentorController@nominate');


    Route::resource('/mentoring_applications', 'MentoringApplicationController');

    /* Mentees Collection */
    Route::get('/mentees', 'MenteeController@index');

    /* Education Collection */

    Route::resource('/educations', 'EducationController');
    Route::resource('/experiences', 'ExperienceController');
    Route::get('/{userId}/educations', 'EducationController@getUserEducations');


    /* Mentoring Session Collection */

    Route::resource('/mentoring_sessions', 'MentoringSessionController');
    Route::resource('/mentoring_session/posts', 'MentoringSessionPostController');
    Route::post('/mentoring_session/post/upvote', 'MentoringSessionPostController@upvote');
    Route::post('/mentoring_session/join', 'MentoringSessionController@join');
    Route::get('/mentoring_session/upcoming', 'MentoringSessionController@upcomingMentoringSessions');


    /* Mentor Application Collection */
    Route::resource('/mentoring_applications', 'MentorApplicationController');
    Route::post('/mentoring_application/approve', 'MentorApplicationController@approve');
    Route::post('/mentoring_application/decline', 'MentorApplicationController@decline');

    /* Reply Collection */
    Route::post('replies', 'ReplyController@store');

    /* Program Collection */
    Route::resource('/programs', 'ProgramController');
    Route::post('/program/invite_mentor', 'ProgramController@inviteMentor');
    Route::post('/program/invite_mentee', 'ProgramController@inviteMentee');
    Route::post('/program/accept_invitation', 'ProgramController@acceptInvitation');
    Route::get('/programs/{id}/mentors', 'ProgramController@getMentors');
    Route::get('/programs/{id}/mentees', 'ProgramController@getMentees');
    Route::get('/programs/{id}/resources', 'ProgramController@getResources');
    Route::any('/programs/{id}/join', 'ProgramController@join');

    /* Task Collection */
    Route::resource('/tasks', 'TaskController');
    Route::post('/tasks/assignees', 'TaskController@assignUser');

    Route::resource('/career_fields', 'CareerFieldController');

    Route::resource('/careers', 'CareerController');

    Route::get('/interest/search', 'InterestController@search');
    Route::resource('/interests', 'InterestController');
    Route::resource('/companies', 'CompanyController');
    Route::post('/companies/{id}/claim', 'CompanyController@claim');

    /** Pathfinder */
    Route::get('/pathfinder/questions', 'PathFinderController@listQuestions');
    Route::post('/pathfinder/find_path', 'PathFinderController@findPath');
    Route::post('/pathfinder/save_path', 'PathFinderController@savePath');

    /** Skills */
    Route::get('/skills', 'SkillGuideController@listSkills');
    Route::get('/skills/{id}', 'SkillGuideController@getSkill');
    
    /** Skills Guids */
    Route::get('/skill_guides/{id}', 'SkillGuideController@getSkillGuide');
    Route::get('/career_paths/{id}/skill_guides', 'SkillGuideController@listSkillGuides');
    Route::put('/skill_guides/{id}', 'SkillGuideController@saveSkillGuide');

    Route::post('/skill_progresses', 'SkillGuideController@saveProgress');
    Route::get('/skill_progresses', 'SkillGuideController@getProgress');

});




// Admin Routes

Route::get('/admin', ['middleware' => 'guest', function() {
    return view('admin');
}]);

// Admin Endpoints
Route::group(['prefix' => '/api/admin'], function (){
    Route::post('/auth/login', 'AdminUserController@authenticate');
    Route::get('/user/me', 'AdminUserController@getCurrentUser');
});

//// Redirect to notify me page
//Route::get('/', ['middleware' => 'guest', function () {
//    return redirect('notify/me');
//}]);
//
//// return notify me page
//Route::get('/notify/me', function (){
//   return view('notifyMe');
//});
//
//Route::post('notify/me', 'WelcomeController@notifyMe');
//
//Route::get('/refer', 'WelcomeController@refer');
