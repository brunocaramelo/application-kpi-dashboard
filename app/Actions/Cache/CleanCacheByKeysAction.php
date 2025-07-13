<?php

namespace App\Actions\Cache;

use App\Actions\Action;

class CleanCacheByKeysAction extends Action
{

    public function handle(array $keys)
    {
        foreach ($keys as $key) {
            $remove = cache()->forget($key);
            \Log::info('remover chave: '.$key);
            \Log::info($remove);
        }

    }
}