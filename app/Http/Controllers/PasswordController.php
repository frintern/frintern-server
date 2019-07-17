<?php

namespace App\Http\Controllers;

use App\Events\ConfirmResetPasswordWasTriggered;
use App\Events\Event;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class PasswordController extends Controller
{
    public function confirmResetPassword(Request $request)
    {
        $email = $request->get('email');
        $validate = Validator::make(['email' => $email], ['email' => 'required|string']);
        if ($validate->fails()) {
            return response()->json(['message' => 'Email is required'], 401);
        }

        $user = User::where('email', $email)->first();
        $token = JWTAuth::fromUser($user);

        if ($user) {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => \Carbon\Carbon::now()
            ]);

            event(new ConfirmResetPasswordWasTriggered($user, $token));
            return response()->json(['message' => 'Please check your email to confirm password reset']);

        } else {
            return response()->json(['message' => 'Email not found']);
        }
    }


    public function resetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 400);
        }

        $currentUser = JWTAuth::parseToken()->authenticate();
        $user = User::find($currentUser['id']);

        if ($user) {
            $user->password = bcrypt($request->get('password'));
            $user->save();

            $token = JWTAuth::fromUser($user);
            return response()->json(compact('token'));
        }

        return response()->json(['message' => 'Unable to reset your password'], 400);
    }
}
