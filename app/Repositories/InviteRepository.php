<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 4/9/16
 * Time: 9:55 PM
 */

namespace App\Repositories;


use App\Invite;

class InviteRepository
{

    private $invite;

    public function __construct()
    {
        $this->invite = new Invite();
    }

    public function create($emails)
    {
        foreach ($emails as $email)
        {
            $this->invite->user_id = auth()->user()->id;
            $this->invite->email = $email;
            $this->invite->created_at = \Carbon\Carbon::now();
            $this->invite->save();
        }
    }

}