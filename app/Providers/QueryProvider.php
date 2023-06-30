<?php

namespace App\Providers;

use App\Models\Query;
use App\Observers\QueryObserver;
use Illuminate\Support\ServiceProvider;

class QueryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Query::observe(QueryObserver::class);
    }
}
