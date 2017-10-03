<?php

namespace Modules\Catalog\Console\Commands;

use Illuminate\Console\Command;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\City;
use Modules\Catalog\Entities\ParseCompanyJson;

class ParseJsonCompany extends Command
{

    private $searchParameter;

    private $hashParameter;

    private $keyParameter;

    private $idHash = '';

    private $progressBar;

    public $cities = [];

    private $cityId;

    public $category = [];

    private $categoryId;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:parseJson';
    
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
        $this->runParse();
    }

    private function runParse()
    {
        $this->cities = self::getCities();
        $this->category = self::getCategory();
        if (!empty($this->cities)) {
            $choice = $this->choice('Select the city for which will be parsing', $this->cities);
            $this->cityId = array_search($choice, $this->cities);
        } else {
            $this->info('Please, add seed for cities in catalog_city table');
            exit;
        }
        if (!empty($this->category)) {
            $choice = $this->choice('Select the city for which will be parsing', $this->category);
            $this->categoryId = array_search($choice, $this->category);
        } else {
            $this->info('Please, add seed for categories in catalog_category table');
            exit;
        }

        //search parameter in ajax response https://2gis.ua/
        $this->searchParameter = $this->ask('Insert search parameter');
        parse_str(parse_url($this->searchParameter, PHP_URL_QUERY), $query);
        $this->hashParameter = $query['hash'];
        $this->keyParameter = $query['key'];
        $this->getListCompany();
        $companyList = $this->getCompanyForParse();
        $this->progressBar = $this->output->createProgressBar(count($companyList));
        $this->saveCompanies($companyList);
        $this->progressBar->finish();
    }

    private function getListCompany()
    {
        $responseDataJson = file_get_contents($this->searchParameter);
        $responseData = json_decode($responseDataJson, true);
        $companyList = $responseData['result']['items'];
        foreach ($companyList as $company) {
            $newCompany = new ParseCompanyJson();
            $id = explode('_', $company['id']);
            $newCompany->company_id = $id[0];
            $newCompany->city_id = $this->cityId;
            try {
                $newCompany->category_id = json_encode([$this->categoryId]);
                $newCompany->save();
            } catch (\Exception $e) {
                $isCompany = ParseCompanyJson::where('company_id', $id[0])->first();
                if (!empty($isCompany)) {
                    $categoryIds = json_decode($isCompany->category_id);
                    $categoryIds = array_merge($categoryIds, [$this->categoryId]);
                    $categoryIdsJson = json_encode($categoryIds);
                    $isCompany->update(['category_id' => $categoryIdsJson]);
                }
            }
        }

        // select changes hash in template "id_hash"
        $this->idHash = explode('_', $companyList[0]['id']);
        $this->idHash = $this->idHash[1];
    }

    private function getCompanyForParse()
    {
        $list = ParseCompanyJson::where('status', 'wait')->get()->toArray();
        return $list;
    }

    private function saveCompanies($list)
    {
        foreach ($list as $companyItem) {
            $companyData = $this->getContentCompany($companyItem['company_id']);
            $companyGallery = $this->getGalleryCompany($companyData['id']);
            $data = ParseCompanyJson::where('company_id', $companyItem['company_id'])->first();
            $data->info = json_encode($companyData);
            $data->gallery = json_encode($companyGallery);
            $data->status = 'done';
            $data->update();
            $this->progressBar->advance();
        }
    }

    private function getContentCompany($id)
    {
        $companyJson = file_get_contents('https://catalog.api.2gis.ru/2.0/catalog/branch/get?id=' . $id . '_' . $this->idHash . '&key=' . $this->keyParameter . '&hash=' . $this->hashParameter . '&see_also_size=4&stat%5Bpr%5D=10&fields=items.adm_div%2Citems.region_id%2Citems.reviews%2Citems.point%2Citems.links%2Citems.name_ex%2Citems.org%2Citems.group%2Citems.see_also%2Citems.dates%2Citems.external_content%2Citems.flags%2Citems.ads.options%2Citems.email_for_sending.allowed%2Chash%2Csearch_attributes');
        $companyData = json_decode($companyJson, true);
        return $companyData['result']['items']['0'];
    }

    private function getGalleryCompany($id)
    {
        $galleryJson = file_get_contents('https://api.photo.2gis.com/2.0/photo/count?key=gYu1s9N1wP&object_id=' . $id . '&object_type=branch&locale=ru_UA&preview_size=100x100%2C304x190%2C304x%2C156x156%2C472x156%2C946x156%2C235x156%2C311x156%2C624x156%2C360x120%2C784x508');
        $companyGallery = json_decode($galleryJson, true);
        return $companyGallery['result']['0'];
    }

    static function getCities()
    {
        $cities = City::all()->pluck('name', 'id')->toArray();
        return $cities;
    }

    static function getCategory()
    {
        $categories = Category::where('parent_id', null)->pluck('name', 'id')->toArray();
        return $categories;
    }
}
