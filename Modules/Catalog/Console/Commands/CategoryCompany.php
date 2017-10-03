<?php

namespace Modules\Catalog\Console\Commands;

use Illuminate\Console\Command;
use Modules\Catalog\Entities\City;
use Modules\Catalog\Entities\Company;

class CategoryCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categoryCompany:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->attachCategoryByCity();
        $this->countCompanyByCategory();
    }

    public function attachCategoryByCity()
    {
        $cities = City::all();
        $categoryIds = [];
        if (!empty($cities)) {
            foreach ($cities as $city) {
                $arrayIds = [];
                $companies = $city->companies;
                if (!empty($companies)) {
                    foreach ($companies as $company) {
                        $categories = $company->categories;
                        if (!empty($categories)){
                            $categoryIds[] = $categories->pluck('id')->toArray();
                            foreach ($categoryIds as $id){
                                $arrayIds = array_unique(array_merge($id, $arrayIds));
                            }
                        }
                    }
                }
                if(!empty($arrayIds)){
                    $city->categories()->sync($arrayIds);
                };
            }
        }
    }

    public function countCompanyByCategory()
    {
        $cities = City::all();
        foreach ($cities as $city){
            $categories = $city->categories;
            if($categories->count()>0){
                foreach ($categories as $category){
                    $companies = Company::whereHas('categories', function ($q) use ($category){
                        $q->where('id', $category->id);
                    })->where('city_id', $city->id)->get();
                    if (count($companies)>0){
                        $city->categories()->updateExistingPivot($category->id, ['count' => count($companies)]);
                    }
                    else{
                        $city->categories()->detach($category->id);
                    }
                };
            };
        }
    }
}
