<?php

namespace Modules\Catalog\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Catalog\Console\Commands\CategoryCompany;
use Modules\Catalog\Console\Commands\ParseCompany;

use Illuminate\Support\ServiceProvider as ServiceProvider;
use Modules\Catalog\Console\Commands\ParseImportCompanyJson;
use Modules\Catalog\Console\Commands\ParseJsonCompany;
use Modules\Catalog\Console\Commands\ProjectRefresh;
use Modules\Catalog\Console\Commands\ServiceCompany;

class ConsoleCommandProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /*$this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('company:parse')->everyMinute();
        });*/
    }

    protected $commands = [
        ParseCompany::class,
        ParseJsonCompany::class,
        ParseImportCompanyJson::class,
        ProjectRefresh::class,
        CategoryCompany::class,
        ServiceCompany::class
    ];

    public function register(){
        $this->commands($this->commands);
    }

}
