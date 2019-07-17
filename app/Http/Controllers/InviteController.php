<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Libraries\APIHandler;
use App\Repositories\InviteRepository;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class InviteController extends Controller
{

    private $inviteRepository;

    private $invite;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->inviteRepository = new InviteRepository();
        $this->invite = new Invite();

    }

    public function sendInvite(Request $request)
    {
        $emails = $request->get('emails');

        $currentUser = User::find(JWTAuth::parseToken()->authenticate()['id']);

        $validator = $this->invite->validate($request);

        if ( $validator->fails() )
        {
            return APIHandler::response(0, $validator->errors(), [], 421);
        }

        $sender = $currentUser->name;

        $this->inviteRepository->create($emails);



        foreach($emails as $email) {
            Mail::send('emails.invite', ['email' => $email, 'sender' => $sender], function($message) use ($email, $sender){
                $message->from('noreply@meetrabbi.com', $sender . " via Meetrabbi");
                $message->subject('Invitation to Join Meetrabbi');
                $message->to($email, $email);
            });

        }

        return APIHandler::response(1, "Invitation has been sent");

    }
}
