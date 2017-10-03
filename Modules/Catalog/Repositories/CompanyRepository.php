<?php

namespace Modules\Catalog\Repositories;

use Modules\Auth\Entities\AuthUserShowLog;
use Modules\Auth\Entities\User;
use Modules\Catalog\Entities\CatalogCityCompanyPopular;
use Modules\Catalog\Entities\Company;
use InfyOm\Generator\Common\BaseRepository;

class CompanyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
      'name',
      'city_id',
      'address',
      'point',
      'short_desc',
      'picture',
      'rating',
      'price_rel'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Catalog\\Presenters\\CompanyPresenter";
    }

    public function getPopularCompanyByCity($cityId)
    {
        //$popularCompanies = [];

        $popularCompaniesPivotList = CatalogCityCompanyPopular::where('city_id', $cityId)
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
        
        /*foreach ($popularCompaniesPivotList as $item){
            $popularCompanies[] = $item->company;
        }*/
        $companyIds = $popularCompaniesPivotList->pluck('company_id')->toArray();

        $list = [];
        foreach ($companyIds as $id){
            $value = $this->find($id);
            $list[] = $value['data'];
        }

        return $list;

    }

    public function getLastViewedCompanies($userId)
    {
        $lastViewedCompaniesLog = AuthUserShowLog::select('entity_id')->with('company')->where('entity',
          'Modules\Catalog\Entities\Company')
          ->where('user_id', $userId)
          ->orderBy('created_at', 'desc')
          ->limit(config('catalog.last_viewed_count'))
          ->get();

        $companyIds = $lastViewedCompaniesLog->pluck('entity_id')->unique()->toArray();

        return $this->findWhereIn('id', $companyIds);
    }
    
}
