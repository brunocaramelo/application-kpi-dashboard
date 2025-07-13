<?php

namespace App\Observers;

use App\Actions\Cache\{CleanCacheByTagAndKeysAction,
                       CleanCacheByTagsAction};
use App\Models\KpiItem;

class ItemKpiObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(KpiItem $item): void
    {
        (new CleanCacheByTagAndKeysAction())->handle([[
            'tag' => 'kpiItem',
            'key' => 'kpiItem:'.$item->id
        ]]);
        (new CleanCacheByTagsAction())->handle(['kpiList']);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(KpiItem $item): void
    {
        (new CleanCacheByTagAndKeysAction())->handle([[
            'tag' => 'kpiItem',
            'key' => 'kpiItem:'.$item->id
        ]]);
        (new CleanCacheByTagsAction())->handle(['kpiList']);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(KpiItem $task): void
    {
        (new CleanCacheByTagAndKeysAction())->handle([[
            'tag' => 'kpiItem',
            'key' => 'kpiItem:'.$item->id
        ]]);
        (new CleanCacheByTagsAction())->handle(['kpiList']);
    }


}
