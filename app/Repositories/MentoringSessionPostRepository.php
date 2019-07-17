<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 9/12/16
 * Time: 10:33 AM
 */

namespace App\Repositories;


use App\MentoringSessionPost;

class MentoringSessionPostRepository
{


    public function createOrUpdate ($postData, $id = null)
    {

        $post = MentoringSessionPost::updateOrCreate(['id' => $id], $postData);

        return $post;

    }

}