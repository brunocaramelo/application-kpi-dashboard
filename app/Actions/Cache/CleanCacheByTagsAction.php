<?php

namespace App\Actions\Cache;

use App\Actions\Action;

class CleanCacheByTagsAction extends Action
{

    public function handle(array $tags)
    {
        foreach ($tags as $tag) {
            cache()->tags($tag)->flush();
        }
    }
}