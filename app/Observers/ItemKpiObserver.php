<?php

namespace App\Observers;

use App\Actions\Cache\{CleanCacheByTagAndKeysAction,
                       CleanCacheByTagsAction};
use App\Models\KpiItem;

class ItemKpiObserver
{
    public function created(KpiItem $item): void
    {
        (new CleanCacheByTagAndKeysAction())->handle([[
            'tag' => 'kpiItem',
            'key' => 'kpiItem:'.$item->id
        ]]);
        (new CleanCacheByTagsAction())->handle(['kpiList']);
    }

    public function updated(KpiItem $item): void
    {
        (new CleanCacheByTagAndKeysAction())->handle([[
            'tag' => 'kpiItem',
            'key' => 'kpiItem:'.$item->id
        ]]);
        (new CleanCacheByTagsAction())->handle(['kpiList']);
    }


    public function deleted(KpiItem $task): void
    {
        (new CleanCacheByTagAndKeysAction())->handle([[
            'tag' => 'kpiItem',
            'key' => 'kpiItem:'.$item->id
        ]]);
        (new CleanCacheByTagsAction())->handle(['kpiList']);
    }


}
