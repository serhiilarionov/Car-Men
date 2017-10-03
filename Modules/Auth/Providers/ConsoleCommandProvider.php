<?php

namespace Modules\Auth\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Auth\Console\Commands\CollectDataShow;

use Illuminate\Support\ServiceProvider as ServiceProvider;

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
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('dataShow:collect')->everyMinute();
        });
    }

    protected $commands = [
        CollectDataShow::class
    ];

    public function register(){
        $this->commands($this->commands);
    }

}
