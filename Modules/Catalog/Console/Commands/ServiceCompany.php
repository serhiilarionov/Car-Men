<?php

namespace Modules\Catalog\Console\Commands;

use Illuminate\Console\Command;
use Modules\Catalog\Entities\Company;
use Modules\Catalog\Entities\Service;

class ServiceCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serviceCompany:attach';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All services attach for company by category, one only use on the test server';

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
        $this->attachServices();
    }

    private function attachServices()
    {
        $services = Service::all()->pluck('category_id', 'id')->toArray();

        $companies = Company::all();

        foreach ($companies as $company){
            $categoriesByCompany = $company->categories;
            $servicesForCompany = [];
            foreach ($categoriesByCompany as $category){
                reset($services);
                while ($catId = current($services)) {
                    if ($catId == $category->id) {
                        $servicesForCompany[] = key($services);
                    }
                    next($services);
                }
                $company->services()->attach($servicesForCompany);
            }
        }
    }
}
