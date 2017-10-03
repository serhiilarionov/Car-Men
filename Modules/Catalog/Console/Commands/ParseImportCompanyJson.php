<?php

namespace Modules\Catalog\Console\Commands;

use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\CompanyDetail;
use Phaza\LaravelPostgis\Geometries\Point;
use Modules\Catalog\Entities\City;
use Modules\Catalog\Entities\Company;
use Modules\Catalog\Entities\ParseCompanyJson;

class ParseImportCompanyJson extends ParseJsonCompany
{

    protected $categoryAssociation = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:importJson';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command import companies parse data from 2gis';
    
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
        $this->categoryAssociation = \Config::get('parseConfig.categoryAssociation');
        $this->importCompany();
    }

    private function importCompany()
    {
        $companies = ParseCompanyJson::where('status', 'done')->where('parse_status', 'wait')->get();
        foreach ($companies as $company) {
            $companyData = $this->prepareDataCompany($company);
            $newCompany = New Company($companyData);
            $newCompany->save();
            $companyDetail = $this->prepareDataCompanyDetail($newCompany->id, $company);
            $newDetail = new CompanyDetail($companyDetail);
            $newDetail->save();
            $companyCategory = $this->convertCategoryCompany($company);
            $newCompany->categories()->attach($companyCategory);
            $company->update(['parse_status' => 'done']);
        }
    }

    private function prepareDataCompany($data)
    {
        $company = [];
        $gallery = [];
        $companyInfo = json_decode($data->info, true);
        $companyGallery = json_decode($data->gallery, true);
        foreach ($companyGallery['albums'] as $image) {
            $gallery[] = $image['main_photo_url'];
        }
        $company['name'] = $companyInfo['name'];
        $company['city_id'] = $data->city_id;
        $company['address'] = $companyInfo['address']['components'][0]['street'] . ', ' . $companyInfo['address']['components'][0]['number'];
        $company['point'] = ['lat' => $companyInfo['point']['lat'], 'lng' => $companyInfo['point']['lon']];
        $company['short_desc'] = isset($companyInfo['ads']['text']) ? $companyInfo['ads']['text'] : '';
        $company['picture'] = $gallery;
        $company['rating'] = 0;
        $company['price_rel'] = 0;
        return $company;
    }

    private function prepareDataCompanyDetail($companyId, $data)
    {
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $companyInfo = json_decode($data->info, true);
        $phones = [];
        $websites = [];
        $emails = [];
        if(isset($companyInfo['contact_groups'])){
            if (count($companyInfo['contact_groups']) > 1) {
                foreach ($companyInfo['contact_groups'] as $contacts) {
                    foreach ($contacts['contacts'] as $contact) {
                        if ($contact['type'] == 'phone') {
                            $phones[] = $contact['value'];
                        }
                        if ($contact['type'] == 'website') {
                            $site = explode('?', $contact['value']);
                            $websites[] = $site[1];
                        }
                        if ($contact['type'] == 'vkontakte') {
                            $websites[] = $contact['value'];
                        }
                        if ($contact['type'] == 'facebook') {
                            $websites[] = $contact['value'];
                        }
                        if ($contact['type'] == 'email') {
                            $emails[] = $contact['value'];
                        }
                    }
                }
            }
            if (count($companyInfo['contact_groups']) == 1) {
                foreach ($companyInfo['contact_groups'][0]['contacts'] as $contact) {
                    if ($contact['type'] == 'phone') {
                        $phones[] = $contact['value'];
                    }
                    if ($contact['type'] == 'website') {
                        $site = explode('?', $contact['value']);
                        $websites[] = $site[1];
                    }
                    if ($contact['type'] == 'vkontakte') {
                        $websites[] = $contact['value'];
                    }
                    if ($contact['type'] == 'facebook') {
                        $websites[] = $contact['value'];
                    }
                    if ($contact['type'] == 'email') {
                        $emails[] = $contact['value'];
                    }
                }
            }
        }

        
        $payment = $this->importPayment($companyInfo);
        
        $companyDetail['phones'] = $phones;
        $companyDetail['email'] = $emails;
        $companyDetail['website'] = $websites;
        $companyDetail['payment'] = $payment;
        $workTime = isset($companyInfo['schedule']) ? $companyInfo['schedule'] : [];
        $companyDetail['work_time'] = [];
        $formattedWorkTime = [];
        foreach($days as $index=>$day) {
            $formattedWorkTime[$index] = (object) [];
            if (array_key_exists($day, $workTime)) {
                $formattedWorkTime[$index]->isActive = true;
                $formattedWorkTime[$index]->timeFrom = $workTime[$day]['working_hours'][0]['from'];
                $formattedWorkTime[$index]->timeTill = $workTime[$day]['working_hours'][0]['to'];
            } else {
                $formattedWorkTime[$index]->isActive = false;
                $formattedWorkTime[$index]->timeFrom = null;
                $formattedWorkTime[$index]->timeTill = null;
            }
            $formattedWorkTime[$index]->lunchTimeFrom = null;
            $formattedWorkTime[$index]->lunchTimeTill = null;
        };
        $companyDetail['work_time'] = $formattedWorkTime;
        $companyDetail['desc'] = isset($companyInfo['ads']['article']) ? $companyInfo['ads']['article'] : '';
        $companyDetail['company_id'] = $companyId;

        return $companyDetail;
    }
    
    public function convertCategoryCompany($data)
    {
        $companyInfo = json_decode($data->info, true);
        $companyRubrics = $companyInfo['rubrics'];
        $category = [];
        foreach ($companyRubrics as $rubric) {
            foreach ($this->categoryAssociation as $catAssoc) {
                $parentId = '';
                if ($catAssoc['id'] == $rubric['id']) {
                    if ($catAssoc['self_car_id'] != "") {
                        $category[] = $catAssoc['self_car_id'];

                        $parentId = Category::where('id', $catAssoc['self_car_id'])->pluck('parent_id')->first();
                        if( !empty($parentId) ){
                            $category[] = $parentId;
                        };
                    }
                }
            }
        }
        return array_unique($category);
    }
    
    public function importPayment($data)
    {
        $payment = [];
        $paymentConvert = [];
        
        try {
            foreach ($data['attribute_groups'] as $attributes) {
                if ($attributes['name'] == 'Способы оплаты') {
                    $payment = $attributes['attributes'];
                };
            };
            
            // delete excess data
            
            foreach ($payment as $item) {
                $paymentConvert[] = $item['name'];
            }
        } catch (\Exception $e) {
        };
        
        return $paymentConvert;
        
    }
    
}
