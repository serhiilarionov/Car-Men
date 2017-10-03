<?php

namespace Modules\Catalog\Providers;

use Illuminate\Support\ServiceProvider as ServiceProvider;
use Modules\Catalog\Console\Commands\CategoryCompany;

class ConsoleCommandServiceProvider extends ServiceProvider
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
        CategoryCompany::class,
    ];

    public function register(){
        $this->commands($this->commands);
    }

}
