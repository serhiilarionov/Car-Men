<?php

namespace Modules\News\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\News\Console\Commands\NewsPush;
use Modules\News\Console\Commands\ParseAutoCentre;
use Modules\News\Console\Commands\ParseAutoConsulting;
use Illuminate\Support\ServiceProvider;

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
            $schedule->command('rss:autoCentre')->everyMinute();
            $schedule->command('rss:autoConsulting')->everyMinute();
        });
        
    }
    
    protected $commands = [
        ParseAutoConsulting::class,
        ParseAutoCentre::class,
        NewsPush::class
    ];
    
    public function register()
    {
        $this->commands($this->commands);
    }
    
}
