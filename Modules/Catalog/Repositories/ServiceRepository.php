<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\Service;
use InfyOm\Generator\Common\BaseRepository;
use Flash;

class ServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];
    
    protected $skipPresenter = true;
    
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Service::class;
    }
    
    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Catalog\\Presenters\\ServicePresenter";
    }

    public function getServices($category_id)
    {
        $services = Service::where('category_id', $category_id)->orderBy('id', 'desc')->get();

        return $services;
    }

    public function syncCategory($servicesId, $categoryId)
    {
        $services = Service::where('category_id', $categoryId)->get();
        if (!empty($services)) {
            foreach ($services as $service) {
                $service->category_id = null;
                $service->save();
            }
        }

        foreach ($servicesId as $serviceId) {
            $service = Service::find($serviceId);
            $service->category_id = $categoryId;
            $service->save();
        }
    }

    public function getServicesForCompany($categoriesId)
    {
        $services = Service::whereIn('category_id', $categoriesId)->get();

        return $services;
    }

    public function createService($categoryId, $serviceName){
        $service = new Service();
        $service->name = $serviceName;
        $service->category_id = $categoryId;
        $service->save();
        return $service->id;
    }

}
