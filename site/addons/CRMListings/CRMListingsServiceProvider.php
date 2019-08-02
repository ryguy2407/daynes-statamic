<?php

namespace Statamic\Addons\CRMListings;

use Illuminate\Pagination\Paginator;
use Statamic\Extend\ServiceProvider;

class CRMListingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Statamic\Addons\CRMListings\Repositories\CRMInterface', 'Statamic\Addons\CRMListings\Repositories\RexListings');
    }
}
