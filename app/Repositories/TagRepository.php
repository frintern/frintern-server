<?php
/**
 * Created by PhpStorm.
 * User: jidesakin
 * Date: 10/13/16
 * Time: 6:45 AM
 */

namespace App\Repositories;


use App\Tag;
use App\Taggable;

class TagRepository
{

    public function addTags($taggableId, $taggableType, $tags)
    {
        foreach ($tags as $tag) {

            $newTag = new Tag();
            $newTag->name = $tag['text'];
            $newTag->save();

            $taggable = new Taggable();
            $taggable->tag_id = $newTag->id;
            $taggable->taggable_id = $taggableId;
            $taggable->taggable_type = $taggableType;
            $taggable->save();
        }
    }

}