<?php

namespace Modules\Catalog\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Modules\Catalog\Entities\ParseCompanyEntity;

class ParseCompany extends Command
{
    /**
     * links cities for http://vse-sto.com.ua/ resource
     *
     * @var array
     */
    private $urlListCitiesVseSto = [
        '1' => 'http://vse-sto.com.ua/krrog',
        '2' => 'http://vse-sto.com.ua/kiev'
    ];

    private $categoriesVseSto = [
        '1' => 'sto',
        '2' => 'azs',
        '3' => 'avtomoyki',
        '4' => 'schinomontazhi'
    ];

    private $categorySlug;

    /**
     * @var integer
     */
    private $cityId;

    private $categoryId;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:parse';
    
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

        $this->info('*********************');
        $this->line('Select source:');
        $this->info('[1] vse-sto.com.ua');
        //$this->info('[2] glo.ua');
        $sources = $this->ask('Your choice?');

        if ($sources == '1'){
            $this->parseVseSto();
        }
        /*if ($sources == '2'){
            $this->parseGlo();
        }*/
    }


    /**
     * function for parse glo
     */

    private function parseGlo()
    {
        $urlCity = $this->choice('Select city', $this->urlListCitiesGlo);
        $this->categorySlug = $this->choice('Select category', $this->categoriesGlo);

        $this->cityId = array_search($urlCity, $this->urlListCitiesGlo);
        $this->categoryId = array_search($this->categorySlug, $this->categoriesGlo);

        $startTime = new \DateTime();
        $this->runParse($urlCity);
        $endTime = new \DateTime();

        $interval = $endTime->diff($startTime);

        $this->info('');
        $this->info('Done! Total time: ' . $interval->format('%h:%i:%s'));
    }


    /**
     * function for parse vse-sto
     */

    private function parseVseSto()
    {
        $urlCity = $this->choice('Select city', $this->urlListCitiesVseSto);
        $this->categorySlug = $this->choice('Select category', $this->categoriesVseSto);

        $this->cityId = array_search($urlCity, $this->urlListCitiesVseSto);
        $this->categoryId = array_search($this->categorySlug, $this->categoriesVseSto);

        $startTime = new \DateTime();
        $this->runParse($urlCity);
        $endTime = new \DateTime();

        $interval = $endTime->diff($startTime);

        $this->info('');
        $this->info('Done! Total time: ' . $interval->format('%h:%i:%s'));
    }

    /**
     * @param $urlCity
     */
    private function runParse($urlCity)
    {
        //prepare status bar
        $this->preparePagesParse($urlCity);
        $this->info('Start parse');

        $urlsForParse = ParseCompanyEntity::where('status', 'wait')->get();
        $progressBar = $this->output->createProgressBar($urlsForParse->count());
        //company links for parse
        $urlsForParse = $urlsForParse->pluck('data_url');

        foreach ($urlsForParse as $urlCompany) {
            $html = file_get_contents($urlCompany);
            $crawler = new Crawler($html);
            $companyDetail = $this->prepareData($crawler, $urlCompany);
            $this->saveCompany($companyDetail);
            $progressBar->advance();
        }
        
    }

    /**
     * prepare parse data for company
     * @param $crawler
     * @param $urlCompany
     * @return array
     */

    private function prepareData($crawler, $urlCompany)
    {
        $companyDetail = [];
        $companyDetail['name'] = $this->parseBlock('//h1/span[@class="fn org"]', $crawler);
        $companyDetail['address'] = $this->parseStrongSpan('Адрес:', $crawler);
        $companyDetail['phone'] = $this->parseStrongSpan('Телефон:', $crawler);
        $companyDetail['website'] = $this->parseStrongLink('Веб-сайт:', $crawler);
        $companyDetail['services'] = $this->parseStrongUl('Виды работ:', $crawler);
        $companyDetail['description'] = $this->parseBlock('//div[@class="main"]/div[2]/p', $crawler);
        $companyDetail['location_description'] = $this->parseBlock('//div[@class="sidebar"]/p', $crawler);
        $companyDetail['image'] = $this->parseImages('//img[@class="photo"]', $crawler);

        $companyDetail['fuel'] = $this->parseStrongText('Марки топлива:', $crawler);
        $companyDetail['logo'] = $this->parseLogo($crawler);
        
        $companyDetail['washing_type'] = $this->parseStrongText('Тип мойки:', $crawler);
        $companyDetail['work_hour'] = $this->parseStrongText('Круглосуточная:', $crawler);
        $companyDetail['car_brand'] = $this->parseStrongUl('Специализируется на обслуживании:', $crawler);
        $companyDetail['services_car_brand'] = $this->parseStrongUl('Специализируется на обслуживании:', $crawler);

        $companyDetail['city_id'] = $this->cityId;
        //$companyDetail['point'] = $this->parseMap($crawler);
        $companyDetail['data_url'] = $urlCompany;
        $companyDetail['category_id'] = $this->categoryId;
        $companyDetail['status'] = 'done';

        return $companyDetail;
    }

    /**
     * parse block li>strong+span
     */
    private function parseStrongSpan($text, $crawler)
    {
        try{
            $content = $crawler->filterXPath('//li[strong[text()="' . $text . '"]]/span')->text();
        }catch (\Exception $e){
            $content = '';
        }
        return $content;
    }

    /**
     * parse block li>strong+text
     */
    private function parseStrongText($text, $crawler)
    {
        try{
            $content = $crawler->filterXPath('//li[strong[text()="' . $text . '"]]')->text();
            $content = trim(str_replace($text, '', $content ));
        }catch (\Exception $e){
            $content = '';
        }
        return $content;
    }

    /**
     * parse block li>strong+a
     */
    private function parseStrongLink($text, $crawler)
    {
        try{
            $content = $crawler->filterXPath('//li[strong[text()="' . $text . '"]]/a')->attr('href');
        }catch (\Exception $e){
            $content = '';
        }
        return $content;
    }

    /**
     * parse block li>strong+ul
     */

    private function parseStrongUl($text, $crawler)
    {
        try{
            $content = $crawler->filterXPath('//li[strong[text()="' . $text . '"]]//a')->each(function (Crawler $node) {
                    return $node->text();
                });
        }catch (\Exception $e){
            $content = [];
        }
        return json_encode($content);
    }

    private function parseImages($xPathParameter, $crawler)
    {
        try {
            $content = $crawler->filterXPath($xPathParameter)->each(function (Crawler $node) {
                return $node->attr('src');
            });;
        } catch (\Exception $e) {
            $content = [];
        }
        return json_encode($content);
    }

    private function parseLogo($crawler)
    {
        try{
            $content = $this->parseBlock('//img[@class="service-logo"]/@src', $crawler);
        }catch (\Exception $e){
            $content = '';
        }
        return $content;
    }

    /**
     * parse yandex map
     */
    
    /*private function parseMap($crawler)
    {
        try{
            $jsYandexMapUrl = $crawler->filterXPath('//script[contains(@src, "http://api-maps.yandex.ru/1.1/index.xml")]/@src')->text();
            $jsYandexMap = file_get_contents($jsYandexMapUrl);
            preg_match('/longitude":(.*?),/', $jsYandexMap, $longitude);
            preg_match('/latitude":(.*?),/', $jsYandexMap, $latitude);
            $point = [$longitude[1], $latitude[1]];
        }catch (\Exception $e){
            $point = [];
        }
        return json_encode($point);
    }*/
    
    /**
     * parse html block on xpath parameter
     *
     * @param $xPathParameter
     * @param $crawler
     * @return string
     */
    private function parseBlock($xPathParameter, $crawler)
    {
        try {
            $content = $crawler->filterXPath($xPathParameter)->text();
        } catch (\Exception $e) {
            $content = '';
        }
        return (string)$content;
    }

    /**
     * @param $data
     */
    private function saveCompany($data)
    {
        $parseCompany = ParseCompanyEntity::where('data_url', $data['data_url']);
        $parseCompany->update($data);
    }
    
    private function preparePagesParse($urlCity)
    {
        $this->info('Please wait, processing counting pages for parse and prepare data');
        
        $number = 1;
        $nextPage = '';
        do {
            $html = file_get_contents($urlCity . '/' . $this->categorySlug . '/?page=' . $number);
            $crawler = new Crawler($html);
            $crawler
                ->filterXPath('//div[@class="main"]/ul/li/a[@class="item-link"]')
                ->each(function (Crawler $node) {
                    $this->saveUrlCompany('http://vse-sto.com.ua' . $node->attr('href'));
                });
            try {
                $nextPage = $crawler->filterXPath('//div[@class="pagination"]/span[@class="step-links"]/a[@class="next"]')->text();
            } catch (\Exception $e) {
                break;
            }
            $number++;
        } while ($nextPage);


        return $number;
    }

    /**
     * @param $url
     */
    private function saveUrlCompany($url)
    {
        $urlCompany = ParseCompanyEntity::where('data_url', $url)->first();
        if (empty($urlCompany->data_url)) {
            $company = new ParseCompanyEntity();
            $company->data_url = $url;
            $company->status = 'wait';
            $company->save();
        }
    }
    
}
