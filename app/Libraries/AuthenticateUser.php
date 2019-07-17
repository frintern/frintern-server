<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 2/6/16
 * Time: 3:54 AM
 */

namespace App\Libraries;


use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\UserRepository;

/**
 * Class AuthenticateUser
 * @package App\Libraries
 */
class AuthenticateUser
{

    /**
     * @var Socialite
     */
    private $socialite;
    /**
     * @var Guard
     */
    private $auth;
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * AuthenticateUser constructor.
     * @param Socialite $socialite
     * @param Guard $auth
     * @param UserRepository $users
     */
    public function __construct(Socialite $socialite, Guard $auth, UserRepository $users)
    {
        $this->socialite = $socialite;
        $this->users = $users;
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param $listener
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute($request, $listener, $provider)
    {
        if (!$request) return $this->getAuthorizationFirst($provider);

        $user = $this->users->findByEmailOrCreate($this->getSocialUser($provider), $provider);

        $this->auth->login($user, true);

        return $this->userHasLoggedIn($user);
    }

    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst($provider)
    {

        return $this->socialite->driver($provider)->redirect();
    }

    /**
     * Get soccial provider
     * @param $provider
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getSocialUser($provider)
    {

        return $this->socialite->driver($provider)->user();
    }


    /**
     * @param $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userHasLoggedIn($user)
    {
        Session::flash('message', 'Welcome, ' . $user->username);

        // Check if user's email has not been verified
        if ($user->status == 0)
        {
            return redirect('onboarding');
        }

        return redirect('dashboard');
    }

}