<?php


namespace App\Providers;

use App\Models\KpiItem;

use App\Observers\ItemKpiObserver;

use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{

    public function boot()
    {
        KpiItem::observe(ItemKpiObserver::class);
    }

    public function register()
    {

    }
}
