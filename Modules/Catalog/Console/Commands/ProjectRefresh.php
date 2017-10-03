<?php

namespace Modules\Catalog\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all project. Refresh all migration and seeds, run all the necessary console commands';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Migration refresh for Catalog module');
        Artisan::call('module:migrate-refresh', ['module' => 'Catalog']);
        $this->info('Migration refresh for Auth module');
        Artisan::call('module:migrate-refresh', ['module' => 'Auth']);
        $this->info('Run seed');
        Artisan::call('db:seed');
        $this->info('Run artisan command [dataShow:collect]');
        Artisan::call('dataShow:collect');
        $this->info('Run artisan command [categoryCompany:count]');
        Artisan::call('categoryCompany:count');
        $this->info('Run artisan command [serviceCompany:attach]');
        Artisan::call('serviceCompany:attach');
    }

}
