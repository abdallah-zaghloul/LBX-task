<?php

namespace Modules\Employee\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(\Modules\Employee\Repositories\EmployeeRepository::class, \Modules\Employee\Repositories\EmployeeRepositoryEloquent::class);
        //:end-bindings:
    }
}
