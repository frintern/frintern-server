<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	private $rules = [
		'email' => 'required|email|unique:pre_users'
	];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

	public function notifyMe(Request $request)
	{

		$validator = Validator::make($request->all(), $this->rules);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}
		
		$newPreUser = [];
		$newPreUser['email'] = $request->get('email');
		$newPreUser['referral_code'] = str_random(10);
        $newPreUser['created_at'] = \Carbon\Carbon::now();
        $newPreUser['updated_at'] = $newPreUser['created_at'];

		$id = DB::table('pre_users')->insertGetId($newPreUser);
        
        if ($request->get('code'))
        {
            $code = $request->get('code');
            DB::table('pre_users')->where('referral_code', $code)->increment('referral_count');

        }

		$preUser = DB::table('pre_users')->find($id);

		// Send email address
		Mail::send('emails.subscribed', ['user' => $preUser], function ($message) use ($preUser) {
			$message->from('noreply@meetrabbi.com', 'MeetRabbi');
			$message->subject('Welcome to MeetRabbi!');
			$message->replyTo('hello@meetrabbi.com');
			$message->to($preUser->email);
		});


		return view('subscribed');

	}


    public function refer(Request $request)
    {
        $code = $request->get('code');

        return view('notifyMe', ['code' => $code]);
    }

}
