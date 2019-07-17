<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 4/19/16
 * Time: 8:57 PM
 */

namespace App\Repositories;


use App\Interest;

class InterestRepository
{
    private $interest;

    public function __construct()
    {
        // Interest is the same as mentoring area
        $this->interest = new Interest();
    }

    public function fetchAll()
    {
        return $this->interest->all();
    }

}