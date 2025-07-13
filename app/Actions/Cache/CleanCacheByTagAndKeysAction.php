<?php

namespace App\Actions\Cache;

use App\Actions\Action;

class CleanCacheByTagAndKeysAction extends Action
{

    public function handle(array $keys)
    {
        foreach ($keys as $key) {
            cache()->tags($key['tag'])->forget($key['key']);
        }

    }
}